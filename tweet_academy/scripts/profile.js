import {Tweets} from "../modules/tweets.mjs";

const thisUser = $("#userTag").text().trim();

new Tweets().requestUserTweets(thisUser);

$("#followUser").click(() => {
    $.post("../controller/controller.php", {action: "follow_user", tag: thisUser}, (response) => {
        const json = JSON.parse(response);
        const errorFollow = $("#errorFollow");
        const errorP = errorFollow.find("p:first");
        if (json.success) {
            $("#followUser").addClass("d-none");
            errorP.addClass("text-success");
            errorFollow.removeClass("d-none");
            errorP.text(json.msg);
        } else {
            errorFollow.removeClass("d-none");
            errorP.addClass("text-danger");
            errorP.text(json.msg);
        }
    })
})