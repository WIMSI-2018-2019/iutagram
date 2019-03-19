import {RECEIVE_IMAGES_ERROR, RECEIVED_IMAGES, REQUEST_IMAGES} from '../actions/image';

const initialState = {
    loading: false,
    error:   false,
    data:    {
        'hydra:member':     [],
        'hydra:totalItems': 0,
    },
};

export default (state = initialState, action) => {
    switch (action.type) {
        case REQUEST_IMAGES:
            return {
                ...state,
                loading: true,
                error:   false,
            };
        case RECEIVE_IMAGES_ERROR:
            return {
                ...state,
                loading: false,
                error:   true,
            };
        case RECEIVED_IMAGES:
            return {
                ...state,
                loading: false,
                error:   false,
                data:    action.payload,
            };
        default:
            return state;
    }
}
