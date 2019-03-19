export const REQUEST_USER = Symbol('@@iutagram/request_user');
export const RECEIVED_USER = Symbol('@@iutagram/received_user');
export const RECEIVE_USER_ERROR = Symbol('@@iutagram/receive_user_error');
export const requestUser = (id, rawToken) => async dispatch => {
    await dispatch({type: REQUEST_USER});

    try {
        const res = await fetch('/api/users/' + id, {
            headers: {
                'Authorization': 'Bearer ' + rawToken,
            }
        });
        const payload = await res.json();

        dispatch({type: RECEIVED_USER, payload});
    } catch (error) {
        dispatch({type: RECEIVE_USER_ERROR, error});
    }
};
