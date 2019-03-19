import {ATTEMPT_LOGIN, LOGIN_ERROR, LOGIN_SUCCESS} from '../actions/login';

const initialState = {
    loading: false,
    error:   null,
    token:   null,
};

export default (state = initialState, action) => {
    switch (action.type) {
        case ATTEMPT_LOGIN:
            return {
                ...state,
                loading: true,
                error:   null,
                token:   null,
            };
        case LOGIN_ERROR:
            return {
                ...state,
                loading: false,
                error:   action.error,
                token:   null,
            };
        case LOGIN_SUCCESS:
            return {
                ...state,
                loading: false,
                error:   null,
                token:   action.payload.token,
            };
        default:
            return state;
    }
}
