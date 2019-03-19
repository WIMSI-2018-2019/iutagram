import {RECEIVE_USER_ERROR, RECEIVED_USER, REQUEST_USER} from '../actions/user';

const initialState = {
    loading: false,
    error:   null,
    item:    null,
};

export default (state = initialState, action) => {
    switch (action.type) {
        case REQUEST_USER:
            return {
                ...state,
                loading: true,
                error:   false,
            };
        case RECEIVE_USER_ERROR:
            return {
                ...state,
                loading: false,
                error:   true,
            };
        case RECEIVED_USER:
            return {
                ...state,
                loading: false,
                error:   false,
                item:    action.payload,
            };
        default:
            return state;
    }
};
