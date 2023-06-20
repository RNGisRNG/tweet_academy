import {User} from "../modules/user.mjs";

$("#formUpdateProfile").submit((event) => {
    event.preventDefault();
    const userInfos = {
        email: $("#Email").val(),
        password: $("#password").val(),
        confirmPassword: $("#confirm-password").val(),
        name: $("#name").val(),
        bio: $("#biography").val(),
        tag: $("#tagname").val(),
    }
    console.log(userInfos)
    const user = new User(userInfos)
    user.updateProfile(handleUpdateProfile)
})

function handleUpdateProfile(response) {
    console.log(response)
}