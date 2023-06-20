export class Tag {
    #tag;

    constructor(tag) {
        if (typeof tag !== 'string') throw new Error('Tag must be a string');
        this.#tag = tag;
    }

    get tag() {
        return this.#tag;
    }

    set tag(tag) {
        if (typeof tag !== 'string') throw new Error('Tag must be a string');
        this.#tag = tag;
    }
}