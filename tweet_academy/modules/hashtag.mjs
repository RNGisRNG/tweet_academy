export class Hashtag {
    #hashtag;

    constructor(hashtag) {
        this.#hashtag = hashtag;
        if (typeof hashtag !== 'string') throw new Error('Hashtag must be a string');
        if (hashtag.length < 1) throw new Error('Hashtag must be at least 1 character long');
    }

    get hashtag() {
        return this.#hashtag;
    }

    set hashtag(hashtag) {
        this.#hashtag = hashtag;
    }
}