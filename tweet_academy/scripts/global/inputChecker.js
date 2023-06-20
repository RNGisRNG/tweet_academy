// DEPRECATED - USE MODULE USER INSTEAD
// function checkForm(userValues) {
//     let inputError = {
//         inputValid: true,
//         error: {}
//     }
//     Object.keys(userValues).forEach(key => {
//         switch (key) {
//             case "name":
//                 inputError.error[key] = {
//                     msg: checkName(userValues[key]),
//                     id: "errorName"
//                 }
//                 break;
//             case "password":
//                 inputError.error[key] = {
//                     msg: checkPassword(userValues[key], userValues["confirmPassword"]),
//                     id: "errorPassword"
//                 }
//                 break;
//             case "email":
//                 inputError.error[key] = {
//                     msg: checkEmail(userValues[key]),
//                     id: "errorEmail"
//                 }
//                 break;
//             case "birthdate":
//                 inputError.error[key] = {
//                     msg: checkBirthdate(userValues[key]),
//                     id: "errorBirthdate"
//                 }
//                 break;
//             default:
//                 break;
//         }
//     })
//     Object.keys(inputError.error).forEach(key => {
//         inputError.inputValid = (inputError.error[key].msg !== "inputValid") ? false : inputError.inputValid
//     })
//     return inputError;
// }
//
// function checkName(name) {
//     if (name === '') return "Enter a name"
//     if (name.length > 24) return "Name is longer than 24 characters"
//     if (name.length < 3) return "Name is too short"
//     if (name.match(/[^a-zA-Z0-9]/)) return "Name contains invalid characters"
//     return "inputValid"
// }
//
// function checkPassword(password, confirmPassword) {
//     if (password === '') return "Enter a password"
//     if (password.length < 7) return "Password is too short"
//     if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) return "Password is too weak"
//     if (password !== confirmPassword) return "Passwords do not match"
//     return "inputValid"
// }
//
// function checkEmail(email) {
//     if (email === '') return "Enter an email"
//     if (!email.match(/(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}/)) return "Email is invalid"
//     return "inputValid"
// }
//
// function checkBirthdate(birthdate) {
//     const today = new Date();
//     const birthdateDate = new Date(birthdate);
//     if (birthdate === '') return "Enter a birthdate"
//     if (birthdateDate >= today) return "Birthdate is in the future"
//     if (today.getFullYear() - birthdateDate.getFullYear() < 18) return "You are too young"
//     return "inputValid"
// }
//
// function handleErrors(object, parent) {
//     Object.keys(object.error).forEach(key => errorMsg(object.error[key].msg, `#${parent} #${object.error[key].id}`))
// }
//
// function errorMsg(msg, id) {
//     const elem = $(id)
//     if (msg !== "inputValid") {
//         elem.text(msg)
//         elem.removeClass('d-none')
//     } else {
//         elem.addClass('d-none')
//     }
// }