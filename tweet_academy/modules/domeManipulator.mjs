export class DomeManipulator {
    element;

    constructor(element) {
        this.element = element;
    }

    displayTweets(tweets) {
        if (tweets.length === 0) {
            this.element.html('')
            this.element.append('<p class="text-danger">No tweets to display</p>')
            return;
        }
        Object.keys(tweets).forEach((key) => {
            this.element.append(this.tweetCard(tweets[key]));
        })
    }

    displayFollowers(followers) {
        //TODO : display followers
    }

    displayUserSearchResult(results) {
        this.element.html('')
        $.each(results, (index, user) => {
            this.element.append(this.userCard(user))
        })
    }

    displayUserTweets(tweets) {
        //TODO : display user tweets
    }

    displayUserFollowings(followed) {
        //TODO : display user followings
    }

    userCard(user) {
        const div = document.createElement('div');
        div.classList.add('mb-2', 'clickable')
        const imgUrl = '../assets/profile_picture_placeholder.webp'
        user.bio = user.bio ? user.bio : 'This user has no bio yet'
        user.lastLogin = user.lastLogin ? user.lastLogin : 'This user was never online'
        const cardHTML = `
                    <div class="card mb-2 clickable">
                        <div class="card-header p-4">
                            <div class="row">
                                <div class="col-3">
                                    <img src="../assets/profile_picture_placeholder.webp" class="img-fluid rounded"
                                         alt="user profile picture">
                                </div>
                                <div class="col-9 d-flex align-items-center">
                                    <p class="card-title">${user.tag}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <p class="card-text text-center">${user.bio}</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="card-text"><small class="text-muted">${user.lastLogin}</small></p>
                        </div>
                    </div>
        `
        div.innerHTML = cardHTML;
        div.onclick = () => {
            window.location.href = `../pages/profile.php?tag=${user.tag}`
        }
        return div;
    }

    tweetCard(tweet) {
        const card = `
        <div class="card mb-4">
                        <div class="card-header p-4">
                            <div class="row">
                                <div class="col-2">
                                    <img src="../assets/profile_picture_placeholder.webp" class="img-fluid rounded">
                                </div>
                                <div class="col-10">
                                    <p class="card-text">
                                        ${tweet.authorName}
                                    </p>
                                    <p class="card-text">
                                        ${tweet.authorTag}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-test">${tweet.tweetContent}</p>
                        </div>
                        <div class="card-footer">
                            ${tweet.sentAt}
                        </div>
                    </div>`
        const div = document.createElement('div');
        div.classList.add('col-12');
        div.innerHTML = card;
        tweet.hashtags.forEach((hashtag) => {
            div.innerHTML = div.innerHTML.replace(hashtag, `<span class="text-primary clickable">${hashtag}</span>`)
        })
        tweet.mentions.forEach((mention) => {
            div.innerHTML = div.innerHTML.replace(mention, `<span class="text-primary clickable">${mention}</span>`)
        })
        return div;
    }
}