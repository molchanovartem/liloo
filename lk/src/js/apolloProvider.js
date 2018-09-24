import Vue from 'vue';
import VueApollo from 'vue-apollo';
import {ApolloLink} from 'apollo-link';
import {ApolloClient} from 'apollo-client';
import {HttpLink} from 'apollo-link-http';
import {setContext} from 'apollo-link-context';
import {InMemoryCache} from 'apollo-cache-inmemory';
import {errorCollection} from "./errorCollection";
import {onError} from "apollo-link-error";

Vue.use(VueApollo);


// @todo рефакторинг
const linkError = onError(({graphQLErrors, networkError}) => {
    const status = networkError && networkError.statusCode ? networkError.statusCode : null;

    if (graphQLErrors) {
        graphQLErrors.map(({category, extensions, message, locations, path}) => {
                if (category === 'graphql') errorCollection.push(errorCollection.CATEGORY_GRAPHQL, message);
                if (category === 'validation') errorCollection.push(errorCollection.CATEGORY_VALIDATION, message);

                if (category === 'attributeValidation') errorCollection.push(errorCollection.CATEGORY_ATTRIBUTE_VALIDATION, extensions);
                /*
                console.log(
                    `[GraphQL error]: Message: ${message}, Location: ${locations}, Path: ${path}`,
                );
                */
            }
        );
    }

    if (+status === 401) {
        errorCollection.push(errorCollection.CATEGORY_UNAUTHORIZED, 'Unauthorized');
    }
});

const authLink = setContext((_, {headers}) => {
    // get the authentication token from local storage if it exists
    const token = localStorage.getItem('token');
    // return the headers to the context so httpLink can read them
    return {
        headers: {
            ...headers,
            authorization: token ? `Bearer ${token}` : "",
        }
    }
});

const commonClient = new ApolloClient({
    link: ApolloLink.from([
        linkError,
        new HttpLink({
            uri: 'http://liloo/api/common/index',
            transportBatching: true,
        })
    ]),
    cache: new InMemoryCache({
        addTypename: false
    }),
    connectToDevTools: true,
    defaultOptions: {
        watchQuery: {
            fetchPolicy: 'network-only',
            errorPolicy: 'ignore',
        },
        query: {
            fetchPolicy: 'network-only',
            errorPolicy: 'ignore',
        },
        mutate: {
            errorPolicy: 'ignore'
        }
    }
});

const lkClient = new ApolloClient({
    link: ApolloLink.from([
        linkError,
        authLink,
        new HttpLink({
            // You should use an absolute URL here
            uri: 'http://liloo/api/lk/index',
            transportBatching: true,
        })
    ]),
    cache: new InMemoryCache({
        addTypename: false
    }),
    connectToDevTools: true,
    defaultOptions: {
        watchQuery: {
            fetchPolicy: 'network-only',
            errorPolicy: 'ignore',
        },
        query: {
            fetchPolicy: 'network-only',
            errorPolicy: 'ignore',
        },
        mutate: {
            errorPolicy: 'ignore'
        }
    }
});

export const apolloProvider = new VueApollo({
    clients: {
        common: commonClient,
        lk: lkClient
    },
    defaultClient: lkClient
});