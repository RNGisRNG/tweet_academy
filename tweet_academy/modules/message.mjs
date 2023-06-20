export class Message {
    hashtagRegex = /#[A-zÀ-ú'-]+/g;
    mentionRegex = /@[A-zÀ-ú'-]+/g;
    content;
    date;
    author
    target;
    element;
    hashtag = [];
    mentions = [];

    constructor(message) {
        this.content = message.content;
        this.date = message.date;
        this.author = message.author;
        this.target = message.target;
        this.getHashtags();
        this.getMentions();
    }

    get content() {
        return this.content;
    }

    get date() {
        return this.date;
    }

    get author() {
        return this.author;
    }

    get target() {
        return this.target;
    }

    getHashtags() {
        const hashtags = this.content.match(this.hashtagRegex);
        if (hashtags !== null) {
            this.hashtag = hashtags;
        }
    }

    getMentions() {
        const mentions = this.content.match(this.mentionRegex);
        if (mentions !== null) {
            this.mentions = mentions;
        }
    }

    createMessageElement(userTag) {
        if (userTag === this.author) {
            return this.createAuthorElement();
        }
        return this.createTargetElement();
    }

    createAuthorElement() {
        this.element = $(`<div class="row mb-4 p-2 justify-content-end">
                    <div class="col-auto card">
                        <div class="card-header p-3 row align-items-center text-end">
                            <h6 class="card-title fw-bold mb-0">${this.author}</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-end">
                                ${this.content}
                            </p>
                        </div>
                        <div class="card-footer row">
                            <p class="card-text text-end">
                                Sent the : ${this.date}
                            </p>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <img src="../assets/profile_picture_placeholder.webp" alt="avatar"
                             class="rounded-circle shadow-1-strong" width="60">
                    </div>
                </div>`)
        if (this.hashtag.length > 0) {
            this.hashtag.forEach((hashtag) => {
                this.element.html(this.element.html().replace(hashtag, `<span class="text-primary clickable">${hashtag}</span>`))
            })
        }
        if (this.mentions.length > 0) {
            this.mentions.forEach((mentions) => {
                this.element.html(this.element.html().replace(mentions, `<span class="text-info clickable">${mentions}</span>`))
            })
        }
        return this.element;

    }

    createTargetElement() {
        return `
                <div class="row mb-4 p-2">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <img src="../assets/profile_picture_placeholder.webp" alt="avatar"
                             class="rounded-circle shadow-1-strong" width="60">
                    </div>
                    <div class="col-auto card">
                        <div class="card-header p-3 row align-items-center">
                            <h6 class="card-title fw-bold mb-0">${this.author}</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                ${this.content}
                            </p>
                        </div>
                        <div class="card-footer row">
                            <p class="card-text">
                                Sent the : ${this.date}
                            </p>
                        </div>
                    </div>
                </div>`
    }
}