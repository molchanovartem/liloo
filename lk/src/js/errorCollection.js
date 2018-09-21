class ErrorCollection {
    constructor() {
        this.observers = [];
    }

    push(category, error) {
        this.observers.forEach(fn => fn(category, error));
    }

    subscribe(fn) {
        this.observers.push(fn);
    }
}

export const errorCollection = new ErrorCollection();

errorCollection.CATEGORY_UNAUTHORIZED = 'unauthorized';
errorCollection.CATEGORY_VALIDATION = 'validation';
errorCollection.CATEGORY_ATTRIBUTE_VALIDATION = 'attributeValidation';
errorCollection.CATEGORY_GRAPHQL = 'graphql';