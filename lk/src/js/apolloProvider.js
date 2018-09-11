import Vue from 'vue';
import { ApolloLink } from 'apollo-link';
import { ApolloClient } from 'apollo-client';
import { HttpLink } from 'apollo-link-http';
import { InMemoryCache } from 'apollo-cache-inmemory';
import VueApollo from 'vue-apollo';

Vue.use(VueApollo);

import { onError } from "apollo-link-error";

const linkError = onError(({ graphQLErrors, networkError }) => {
    if (graphQLErrors)
        console.log(graphQLErrors);
        graphQLErrors.map(({ message, locations, path }) =>
            console.log(
                `[GraphQL error]: Message: ${message}, Location: ${locations}, Path: ${path}`,
            ),
        );

    if (networkError) console.log(`[Network error]: ${networkError}`);
});

let httpLink = new HttpLink({
    // You should use an absolute URL here
    uri: 'http://liloo/api/graphql/index',
    transportBatching: true,
});

const link = ApolloLink.from([linkError, httpLink]);

let apolloClient = new ApolloClient({
    link: link,
    cache: new InMemoryCache(),
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
    defaultClient: apolloClient
});