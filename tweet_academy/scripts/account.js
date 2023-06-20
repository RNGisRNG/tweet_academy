import {InputsChecker} from '../modules/inputsChecker.mjs'

const formSignUp = $('formSignUp')
const formSignIn = $('formSignIn')

function changeForm(event) {
    event.preventDefault();
    formSignUp.toggleClass('d-none')
    formSignIn.toggleClass('d-none')
}

formSignIn.submit(event => {
    event.preventDefault();
    const userValues = {
        email: $('#signInEmail').val(),
        password: $('#signInPassword').val(),
        type: 'signIn',
    }
    sendAjax('../scripts/account/account.php', 'POST', userValues, handleSignIn)
})
formSignUp.submit(event => {
    event.preventDefault();
    let userValues = {
        email: $('#signUpEmail').val(),
        password: $('#signUpPassword').val(),
        confirmPassword: $('#signUpConfirmPassword').val(),
        name: $('#signUpName').val(),
        birthdate: $('#signUpBirthdate').val(),
        type: 'signUp',
    }

    let inputError = new InputsChecker(userValues)
    // let inputError = checkForm(userValues)
    // if (inputError.inputValid) {
    //     handleErrors(inputError, "formSignUp")
    //     sendAjax('../scripts/account/account.php', 'POST', userValues, handleSignIn)
    // } else {
    //     handleErrors(inputError, "formSignUp")
    // }
})

function handleSignIn(data) {
    if (data.error) {
        console.log(data.error)
    } else {
        console.log(data)
    }
}