import {combineReducers} from 'redux';

import images from './images';
import login from './login';
import user from './user';

export default combineReducers({
    images,
    login,
    user,
});
