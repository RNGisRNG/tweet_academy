export class InputsChecker {
    allGood = true;
    inputsErrors = {}

    constructor(inputs) {
        if (inputs === undefined) throw new Error('Inputs are undefined')
        this.inputs = inputs;
        this.#checkInputs()
        this.#cleanInputErrors()
        return !(!this.allGood);
    }

    #checkInputs() {
        Object.keys(this.inputs).forEach(input => {
            switch (input) {
                case 'email':
                    const email = {
                        msg: this.#checkEmail(),
                        id: `errorEmail`
                    }
                    this.inputsErrors.email = email
                    break;
                case 'name':
                    const name = {
                        msg: this.#checkName(),
                        id: `errorName`
                    }
                    this.inputsErrors.name = name
                    break;
                case 'password':
                    const password = {
                        msg: this.#checkPassword(),
                        id: `errorPassword`
                    }
                    this.inputsErrors.password = password
                    break;
                case 'confirmPassword':
                    break;
                case 'birthdate':
                    const birthdate = {
                        msg: this.#checkBirthdate(),
                        id: `errorBirthdate`
                    }
                    this.inputsErrors.birthdate = birthdate
                    break;
                case 'bio':
                    const bio = {
                        msg: this.#checkBio(),
                        id: `errorBio`
                    }
                    this.inputsErrors.bio = bio
                    break;
                case 'tag':
                    const tag = {
                        msg: this.#checkTag(),
                        id: `errorTag`
                    }
                    this.inputsErrors.tag = tag
                    break;
                case 'tweet':
                    const tweet = {
                        msg: this.#checkTweet(),
                        id: `errorTweet`
                    }
                    this.inputsErrors.tweet = tweet
                    break;
                case 'comment':
                    const comment = {
                        msg: this.#checkComment(),
                        id: `errorComment`
                    }
                    this.inputsErrors.comment = comment
                    break;
                case 'search':
                    const search = {
                        msg: this.#checkSearch(),
                        id: `errorSearch`
                    }
                    this.inputsErrors.search = search
                    break;
                case 'picture':
                    const picture = {
                        msg: this.#checkPicture(),
                        id: `errorPicture`
                    }
                    this.inputsErrors.picture = picture
                    break;
                case 'hashtag':
                    const hashtag = {
                        msg: this.#checkHashtag(),
                        id: `errorHashtag`
                    }
                    this.inputsErrors.hashtag = hashtag
                    break;
                default:
                    console.log("Input not found")
                    break;
            }
        })
    }

    #cleanInputErrors() {
        Object.keys(this.inputsErrors).forEach(input => {
            if (this.inputsErrors[input].msg !== 'inputValid') this.allGood = false
            else delete this.inputsErrors[input]
        })
    }

    #checkName() {
        if (this.inputs.name === '') return 'Enter a name'
        if (this.inputs.name.length > 24) return 'Name is longer than 24 characters'
        if (this.inputs.name.length < 3) return 'Name is too short'
        if (this.inputs.name.match(/[^a-zA-Z0-9]/)) return 'Name contains invalid characters'
        return 'inputValid'
    }

    #checkEmail() {
        console.debug(this.inputs.email)
        if (this.inputs.email === '') return 'Enter an email'
        if (!this.inputs.email.match(/(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}/)) return 'Email is invalid'
        return 'inputValid'
    }

    #checkPassword() {
        if (this.inputs.password === '') return 'Enter a password'
        if (this.inputs.password.length < 7) return 'Password is too short'
        if (!this.inputs.password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) return 'Password is too weak'
        if (this.inputs.password !== this.inputs.confirmPassword) return 'Passwords do not match'
        return 'inputValid'
    }

    #checkBirthdate() {
        const today = new Date();
        const birthdate = new Date(this.inputs.birthdate);
        if (this.inputs.birthdate === '') return 'Enter a birthdate'
        if (birthdate >= today) return 'Birthdate is in the future'
        if (today.getFullYear() - birthdate.getFullYear() < 18) return 'You are too young'
        return 'inputValid'
    }

    #checkBio() {
        if (this.inputs.bio === '') return 'Enter a bio'
        if (this.inputs.bio.length > 139) return 'Bio is too long'
        return 'inputValid'
    }

    #checkTag() {
        const tag = this.inputs.tag.replace('@', '')
        if (tag === '') return 'Enter a tag'
        if (tag.length > 24) return 'Tag is too long'
        if (tag.match(/[^a-zA-Z0-9]/)) return 'Tag contains invalid characters'
        return 'inputValid'
    }

    #checkTweet() {
        if (this.inputs.tweet === '') return 'Enter a tweet'
        if (this.inputs.tweet.length > 139) return 'Tweet is too long'
        return 'inputValid'
    }

    #checkComment() {
        if (this.inputs.comment === '') return 'Enter a comment'
        if (this.inputs.comment.length > 139) return 'Comment is too long'
        return 'inputValid'
    }

    #checkSearch() {
        if (this.inputs.search === '') return 'Enter a search'
        if (this.inputs.search.length > 24) return 'Search is too long'
        return 'inputValid'
    }

    #checkPicture() {
        if (this.inputs.picture === '') return 'Enter a picture'
        return 'inputValid'
    }

    #checkHashtag() {
        const hashtag = this.inputs.hashtag.replace('#', '')
        if (hashtag === '') return 'Enter a hashtag'
        if (hashtag.length > 24) return 'Hashtag is too long'
        if (hashtag.match(/[^a-zA-Z0-9]/)) return 'Hashtag contains invalid characters'
        return 'inputValid'
    }

    resetErrors() {
        this.inputsErrors = {}
        this.allGood = true
        Object.keys(this.inputs).forEach(input => {
            const element = $(`#${this.inputs[input].id}`)
            if (element.length > 0) {
                $(`#${this.inputsErrors[input].id}`).html('')
            }
        })
    }

    displayErrors() {
        Object.keys(this.inputsErrors).forEach(input => {
            $(`#${this.inputsErrors[input].id}`).html(this.inputsErrors[input].msg)
        })
    }
}