import {User} from "../modules/user.mjs";

const loginForm = $("#sendLogin");
const signUpForm = $("#sendRegister");
loginForm.submit((event) => {
    console.log("Fuck")
    event.preventDefault();
    const userInfos = {
        email: $("#loginEmail").val(),
        password: $("#loginPassword").val(),
    }
    const user = new User(userInfos)
    user.login(handleLogin)
})

signUpForm.submit((event) => {
    event.preventDefault();
    const userInfos = {
        email: $("#registerEmail").val(),
        password: $("#registerPassword").val(),
        confirmPassword: $("#registerConfirmPassword").val(),
        birthdate: $("#registerBirthdate").val(),
        name: $("#registerName").val(),
    }
    console.log(userInfos)
    const user = new User(userInfos)
    user.register(handleRegister)
})

function handleLogin(response) {
    const json = JSON.parse(response)
    if (!json.success) {
        const elemError = $("#errorSignIn")
        elemError.toggleClass('d-none')
        elemError.text(json.msg)
    } else {
        window.location.href = '../index.php'
    }
}

function handleRegister(response) {
    const json = JSON.parse(response)
    if (!json.success) {
        const elemError = $("#errorSignUp")
        elemError.toggleClass("d-none")
        elemError.text(json.msg)
    } else {
        window.location.href = "../index.php"
    }
}

$("#signUpButton").click((event) => {
    changeForm(event)
})
$("#signInButton").click((event) => {
    changeForm(event)
})


function changeForm(event) {
    event.preventDefault();
    loginForm.toggleClass('d-none')
    signUpForm.toggleClass('d-none')
}