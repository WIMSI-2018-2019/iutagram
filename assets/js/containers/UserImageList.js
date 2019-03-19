import React, {PureComponent} from 'react';
import {connect} from 'react-redux';
import PropTypes from 'prop-types';
import {bindActionCreators} from 'redux';

import {Grid, Header} from 'semantic-ui-react';
import Loader from '../components/Loader';
import UserType from '../prop-types/user';
import ImageCard from '../components/ImageCard';
import {requestUser} from '../actions/user';

class UserImageList extends PureComponent {
    componentDidMount() {
        if (this.props.token) {
            this.props.requestUser(1, this.props.token.rawToken);
        }
    }

    render() {
        return (
            <div>
                <Header as='h1'>Moi</Header>

                <Loader active={this.props.loading}/>
                {this.props.user && (
                    <Grid columns={3}>
                        {this.props.user.images.map(image => (
                            <Grid.Column key={image['@id']}>
                                <ImageCard image={image}/>
                            </Grid.Column>
                        ))}
                    </Grid>
                )}
            </div>
        );
    }
}

UserImageList.propTypes = {
    requestUser: PropTypes.func.isRequired,
    loading:     PropTypes.bool.isRequired,
    user:        UserType,
};

export default connect(
    state => ({
        user:    state.user.item,
        loading: state.user.loading,
        token:   state.login.token,
    }),
    dispatch => ({
        requestUser: bindActionCreators(requestUser, dispatch),
    }),
)(UserImageList);
