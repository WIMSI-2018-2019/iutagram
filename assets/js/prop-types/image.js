import PropTypes from 'prop-types';

import UserType from './user';

export default PropTypes.shape({
    '@id':      PropTypes.string.isRequired,
    nbComments: PropTypes.number.isRequired,
    nbLikes:    PropTypes.number.isRequired,
    path:       PropTypes.string.isRequired,
    text:       PropTypes.string.isRequired,
    createdAt:  PropTypes.string.isRequired,
    user:       UserType.isRequired,
});
