import {User} from "../modules/user.mjs";
import {DomeManipulator} from "../modules/domeManipulator.mjs";
import {Tweets} from "../modules/tweets.mjs";

const searchForm = $("#searchUser");
const sendTweetForm = $("#sendTweet");

getFollowedUserTweets();

searchForm.submit((event) => {
    event.preventDefault();
    const data = {
        search: searchForm.find("#inputSearch").val(),
    }
    const user = new User(data);
    user.searchUser(handleUserSearch)
})

sendTweetForm.submit((event) => {
    event.preventDefault();
    const tweetContent = sendTweetForm.find("textarea").val();
    const tweet = new Tweets();
    tweet.sendTweet(tweetContent, handleTweet)
})


function handleUserSearch(response) {
    const json = JSON.parse(response)
    searchForm.find("input").removeClass('is-valid is-invalid')
    searchForm.find(".form-floating").removeClass('is-valid is-invalid')
    if (!json.success) {
        searchForm.find(".form-floating").toggleClass('is-invalid')
        searchForm.find("input").toggleClass('is-invalid')
        searchForm.find(".invalid-feedback").text(json.msg)
    } else {
        const elemSearchResult = $("#searchResult")
        searchForm.find(".form-floating").toggleClass('is-valid')
        searchForm.find("input").toggleClass('is-valid')
        if (elemSearchResult.hasClass('d-none')) elemSearchResult.toggleClass('d-none')
        new DomeManipulator(elemSearchResult).displayUserSearchResult(json.data)
    }
}

function handleTweet(response) {
    const json = JSON.parse(response)
    sendTweetForm.find("textarea").removeClass('is-valid is-invalid')
    sendTweetForm.find(".form-floating").removeClass('is-valid is-invalid')
    if (!json.success) {
        sendTweetForm.find(".form-floating").toggleClass('is-invalid')
        sendTweetForm.find("textarea").toggleClass('is-invalid')
        sendTweetForm.find(".invalid-feedback").text(json.msg)
    } else {
        sendTweetForm.find("textarea").val("")
        sendTweetForm.find("textarea").toggleClass('is-valid')
        sendTweetForm.find(".form-floating").toggleClass('is-valid')
        sendTweetForm.find(".valid-feedback").text(json.msg)
    }
}

function getFollowedUserTweets() {
    new Tweets().requestFollowedUsersTweets($("#tweets"));
}