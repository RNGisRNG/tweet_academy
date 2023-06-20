export class Tweet {
    hashtagRegex = /#[A-zÀ-ú'-]+/g;
    mentionRegex = /@[A-zÀ-ú'-]+/g;
    authorTag;
    authorName;
    sentAt;
    updatedAt;
    tweetContent;
    hashtags = [];
    mentions = [];
    likes = [];
    likesCount;
    comments = [];
    commentsCount;

    constructor(tweet) {
        this.authorTag = tweet.authorTag;
        this.authorName = tweet.authorName;
        this.sentAt = tweet.sentAt;
        this.updatedAt = tweet.updatedAt;
        this.tweetContent = tweet.tweetContent;
        this.getTweetInfos();
    }

    getTweetInfos() {
        this.getHashtags();
        this.getMentions();
    }

    getHashtags() {
        const hashtags = this.tweetContent.match(this.hashtagRegex);
        if (hashtags !== null) {
            this.hashtags = hashtags;
        }
    }

    getMentions() {
        const mentions = this.tweetContent.match(this.mentionRegex);
        if (mentions !== null) {
            this.mentions = mentions;
        }
    }

    getLikes() {
        //TODO GET LIKES
    }

    getComments() {
        //TODO GET COMMENTS
    }
}