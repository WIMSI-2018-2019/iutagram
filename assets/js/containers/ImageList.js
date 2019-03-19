import React, {PureComponent} from 'react';
import {connect} from 'react-redux';
import PropTypes from 'prop-types';
import {bindActionCreators} from 'redux';
import {Grid, Header, Image} from 'semantic-ui-react';

import {requestImages} from '../actions/image';
import Loader from '../components/Loader';
import ImageType from '../prop-types/image';
import ImageCard from '../components/ImageCard';

class ImageList extends PureComponent {
    componentDidMount() {
        this.props.requestImages();
    }

    render() {
        return (
            <div>
                <Header as='h1'>Photos</Header>
                <Loader active={this.props.loading} />
                <Grid columns={3}>
                    {this.props.images.map(image => (
                        <Grid.Column key={image['@id']}>
                            <ImageCard image={image} />
                        </Grid.Column>
                    ))}
                </Grid>
            </div>
        );
    }
}

ImageList.propTypes = {
    requestImages: PropTypes.func.isRequired,
    loading:       PropTypes.bool.isRequired,
    images:        PropTypes.arrayOf(ImageType).isRequired,
};

export default connect(
    state => ({
        images:  state.images.data['hydra:member'],
        loading: state.images.loading,
    }),
    dispatch => ({
        requestImages: bindActionCreators(requestImages, dispatch),
    }),
)(ImageList);
