import {DomeManipulator} from "./domeManipulator.mjs";
import {InputsChecker} from "./inputsChecker.mjs";
import {Tweet} from "./tweet.mjs";

export class Tweets {
    #tweets = [];

    constructor(tweets) {
        this.tweets = [];
    }

    requestFollowedUsersTweets(element) {
        const data = {
            action: 'get_tweets_from_followers',
        }
        $.get("../controller/controller.php", data, (response) => {
            const json = JSON.parse(response);
            if (json.success) {
                this.#tweets = json.data;
                const tweetsClasses = [];
                Object(this.#tweets).forEach((tweet) => {
                    const tweetClass = new Tweet(tweet);
                    tweetsClasses.push(tweetClass);
                })
                this.#tweets = tweetsClasses;
                element.toggleClass('d-none')
                new DomeManipulator(element).displayTweets(this.#tweets);
            } else {
                const errorTweets = $("#errorTweets");
                if (errorTweets.hasClass('d-none')) errorTweets.toggleClass('d-none')
                errorTweets.text(json.msg);
            }
        })
    }

    sendTweet(tweet, callback) {
        try {
            const checker = new InputsChecker({tweet: tweet})
            if (checker.allGood === false) {
                callback(JSON.stringify({success: false, msg: checker.inputsErrors.tweet.msg}))
                return;
            }
            const data = {
                action: 'send_tweet',
                tweetContent: tweet,
            }
            $.post("../controller/controller.php", data, (response) => {
                callback(response);
            })
        } catch (e) {
            console.error(e)
        }
    }

    requestUserTweets(userTag) {
        try {
            const data = {
                action: 'get_user_tweets',
                tag: userTag,
            }
            $.get("../controller/controller.php", data, (response) => {
                const json = JSON.parse(response);
                if (json.success) {
                    this.#tweets = json.data;
                    const tweetsClasses = [];
                    Object(this.#tweets).forEach((tweet) => {
                        const tweetClass = new Tweet(tweet);
                        tweetsClasses.push(tweetClass);
                    })
                    this.#tweets = tweetsClasses;
                    const tweetsContainer = $("#tweetsContainer");
                    tweetsContainer.empty();
                    new DomeManipulator(tweetsContainer).displayTweets(this.#tweets);
                } else {
                    $(`<p class="text-danger">${json.msg}</p>`).appendTo($("#tweetsContainer"));
                }
            })
        } catch (e) {
            console.error(e)
        }
    }
}