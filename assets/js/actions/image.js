export const REQUEST_IMAGES = Symbol('@@iutagram/request_images');
export const RECEIVED_IMAGES = Symbol('@@iutagram/received_images');
export const RECEIVE_IMAGES_ERROR = Symbol('@@iutagram/receive_image_error');
export const requestImages = () => async dispatch => {
    await dispatch({type: REQUEST_IMAGES});

    try {
        const res = await fetch('/api/images');
        const payload = await res.json();

        dispatch({type: RECEIVED_IMAGES, payload});
    } catch (error) {
        dispatch({type: RECEIVE_IMAGES_ERROR, error});
    }
};
