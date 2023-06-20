//TODO DOES NOTHING YET BUT WILL HANDLE INPUTS ERRORS IF I HAVE TIME
export class HandleInputsErrors {
    inputsErrors = {}
    inputsType = ['email', 'name', 'password', 'confirmPassword', 'birthdate', 'bio', 'tag', 'tweet', 'comment', 'search', 'picture', 'hashtag'];

    constructor(inputsErrors) {
        this.inputsErrors = inputsErrors;
    }
}