import {InputsChecker} from "./inputsChecker.mjs";

export class User {

    #infos
    function

    constructor(infos) {
        this.#infos = infos;
    }

    checkInputs() {
        const checker = new InputsChecker(this.#infos);
        if (!checker.allGood) {
            checker.displayErrors();
        }
        checker.resetErrors();
        return checker.allGood
    }

    login(callback) {
        try {
            let data = {
                email: this.#infos.email,
                password: this.#infos.password,
                action: 'login'
            }
            $.post('../controller/controller.php', data, (response) => {
                callback(response)
            })
            return true;
        } catch (e) {
            console.log(e)
            return false;
        }
    }

    register(callback) {
        if (!this.checkInputs()) return false;
        try {
            let data = {
                email: this.#infos.email,
                password: this.#infos.password,
                confirmPassword: this.#infos.confirmPassword,
                birthdate: this.#infos.birthdate,
                name: this.#infos.name,
                action: 'register'
            }
            $.post('../controller/controller.php', data, (response) => {
                callback(response)
            })
            return true;
        } catch (e) {
            console.log(e)
            return false
        }
    }

    getUser(callback) {
        try {
            const data = {
                tag: this.#infos.tag,
                action: 'getUser'
            }
            $.post('../controller/controller.php', data, (response) => {
                callback(response)
            })
            return true;
        } catch (e) {
            console.log(e)
            return false;
        }
    }

    updateProfile(callback) {
        if (!this.checkInputs()) return false;
        try {
            let data = {
                email: this.#infos.email,
                password: this.#infos.password,
                birthdate: this.#infos.birthdate,
                status: this.#infos.bio,
                name: this.#infos.name,
                tag: this.#infos.tag,
                action: 'update_profile'
            }
            $.post('../controller/controller.php', data, (response) => {
                callback(response)
            })
            return true;
        } catch (e) {
            console.log(e)
            return false
        }
    }

    updateTag(callback) {
        try {
            if (!this.checkInputs()) return false;
            let data = {
                tag: this.#infos.tag,
                action: 'updateTag'
            }
            $.post('../controller/controller.php', data, (response) => {
                callback(response)
            })
            return true;
        } catch (e) {
            console.log(e)
            return false
        }
    }

    searchUser(callback) {
        try {
            let data = {
                search: this.#infos.search,
                action: 'search_user'
            }
            $.post('../controller/controller.php', data, (response) => {
                callback(response)
            })
            return true;
        } catch (e) {
            console.log(e)
            return false
        }
    }
}