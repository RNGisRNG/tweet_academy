import {Message} from "./message.mjs";

export class Conversation {
    #user;
    #target;
    #element;
    #form;

    constructor(conversation) {
        this.#target = conversation.target;
        this.#user = $("body").data("tag");
    }

    get target() {
        return this.#target;
    }

    createConversationElement() {
        this.#element = $(`
            <div class="row align-items-center mt-2 border border-light-subtle rounded p-2">
                <div class="col-4">
                    <img src="../assets/profile_picture_placeholder.webp" alt="avatar"
                         class="rounded-circle me-3 shadow-1-strong" width="60">
                </div>
                <div class="col-8">
                    <h6 class="mb-0">${this.#target}</h6>
                </div>
            </div>`);
        this.#createConversationEvent();
        return this.#element;
    }

    #createConversationEvent() {
        this.#element.click(() => {
            this.#requestMessages();
            $("#windowConversations").find(".bg-light-subtle").removeClass("bg-light-subtle");
            this.#element.toggleClass("bg-light-subtle");
        })
    }

    #requestMessages() {
        $.get("../controller/controller.php", {action: "get_messages", target: this.#target}, (data) => {
            const json = JSON.parse(data);
            const windowMessage = $("#windowMessages");
            windowMessage.html("")
            if (!json.success) {
                console.log(`Request failed: ${json.msg}`);
                return;
            }
            Object.keys(json.data).forEach((message) => {
                const messageClass = new Message(json.data[message]);
                windowMessage.append(messageClass.createMessageElement(this.#user));
            })
            this.createSendMessage();
        })
    }

    createSendMessage() {
        this.#form = $(`
            <form class="row mt-2 justify-content-end has-validation" id="sendMessage">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control bg-dark" placeholder="Write a message here"
                                  id="inputMessage" style="height: 100px"></textarea>
                        <label for="inputMessage">Message</label>
                    </div>
                    <div class="invalid-feedback ms-1">
                    </div>
                    <div class="valid-feedback ms-1">
                    </div>
                </div>
                <div class="col-auto mt-2">
                    <button class="btn btn-primary" type="submit" id="btnTweet">Send</button>
                </div>
            </form>
        `)
        $("#windowMessages").append(this.#form);
        this.#form.submit((event) => {
            event.preventDefault();
            this.#sendMessage();
        })
    }

    #sendMessage() {
        $.post('../controller/controller.php', {
            action: "send_message",
            target: this.#target,
            msgContent: this.#form.find("#inputMessage").val()
        }, (data) => {
            const json = JSON.parse(data);
            const sendMessageForm = $("#sendMessage");
            sendMessageForm.find("textarea").removeClass('is-valid is-invalid')
            sendMessageForm.find(".form-floating").removeClass('is-valid is-invalid')
            if (!json.success) {
                sendMessageForm.find(".form-floating").toggleClass('is-invalid')
                sendMessageForm.find("textarea").toggleClass('is-invalid')
                sendMessageForm.find(".invalid-feedback").text(json.msg)
            } else {
                sendMessageForm.find("textarea").val("")
                sendMessageForm.find("textarea").toggleClass('is-valid')
                sendMessageForm.find(".form-floating").toggleClass('is-valid')
                sendMessageForm.find(".valid-feedback").text(json.msg)
                this.#requestMessages();
            }
        })
    }

}