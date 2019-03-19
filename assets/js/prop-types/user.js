import PropTypes from 'prop-types';

export default PropTypes.shape({
    '@id':     PropTypes.string.isRequired,
    createdAt: PropTypes.string.isRequired,
    email:     PropTypes.string.isRequired,
    images:    PropTypes.arrayOf(
        PropTypes.shape({
            '@id':      PropTypes.string.isRequired,
            nbComments: PropTypes.number.isRequired,
            nbLikes:    PropTypes.number.isRequired,
            path:       PropTypes.string.isRequired,
            text:       PropTypes.string.isRequired,
            createdAt:  PropTypes.string.isRequired,
        })
    ),
});
