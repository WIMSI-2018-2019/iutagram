// assets/js/app.js

import '@babel/polyfill';

import React from 'react';
import {Provider} from 'react-redux';
import ReactDOM from 'react-dom';
import {applyMiddleware, createStore} from 'redux';
import {createLogger} from 'redux-logger';
import thunk from 'redux-thunk';

import {LOGIN_SUCCESS} from './actions/login';
import Application from './containers/App';
import reducer from './reducers';

import 'semantic-ui-css/semantic.min.css'
import '../css/app.css';


const middleware = [thunk];
if (process.env.NODE_ENV !== 'production') {
    middleware.push(createLogger());
}

const store = createStore(reducer, applyMiddleware(...middleware));

// app.js
if (localStorage.getItem('jwt')) {
    const token = JSON.parse(localStorage.getItem('jwt'));

    const tokenExpiresAt = token.payload.exp;
    const currentTimestamp = Date.now() / 1000;
    const threshold = 300;

    if (currentTimestamp + threshold < tokenExpiresAt) {
        store.dispatch({
            type:    LOGIN_SUCCESS,
            payload: {token}
        });
    }
}

ReactDOM.render(
    <Provider store={store}>
        <Application />
    </Provider>,
    document.getElementById('app'),
);
