import {Conversation} from "../modules/conversation.mjs";

const windowMessages = $("#windowMessages");
const windowConversations = $("#windowConversations");

const conversations = {}
const messages = {}

$.get("../controller/controller.php", {action: "get_user_conversations"}, (data) => {
    const json = JSON.parse(data);
    if (!json.success) {
        console.log(`Request failed: ${json.msg}`);
        return;
    }
    windowConversations.toggleClass("d-none");
    Object.keys(json.data).forEach((user) => {
        const conversation = new Conversation(json.data[user]);
        windowConversations.append(conversation.createConversationElement());
    });
})
