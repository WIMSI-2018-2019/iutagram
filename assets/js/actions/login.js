export const ATTEMPT_LOGIN = Symbol('@@iutagram/attempt_login');
export const LOGIN_SUCCESS = Symbol('@@iutagram/login_success');
export const LOGIN_ERROR = Symbol('@@iutagram/login_error');

export const attemptLogin = (username, password) => async dispatch => {
    try {
        dispatch({type: ATTEMPT_LOGIN});
        const res = await fetch('/api/login_check', {
            method:  'POST',
            body:    JSON.stringify({username, password}),
            headers: {
                'Accept':       'application/json',
                'Content-Type': 'application/json',
            },
        });

        if (200 !== res.status) {
            dispatch({type: LOGIN_ERROR, error: res.statusText});

            return;
        }

        const data = await res.json();
        const token = decodeJWT(data.token);
        localStorage.setItem('jwt', JSON.stringify(token));

        dispatch({type: LOGIN_SUCCESS, payload: {token}});
    } catch (error) {
        console.error(error);
        dispatch({type: LOGIN_ERROR, error: {}});
    }
};

function decodeJWT(raw) {
    const parts = raw.split('.');

    return {
        rawToken:  raw,
        headers:   JSON.parse(atob(parts[0])),
        payload:   JSON.parse(atob(parts[1])),
        signature: parts[2],
    };
}
