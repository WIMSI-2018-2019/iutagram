import React from 'react';

import ImageType from '../prop-types/image';
import {Image} from 'semantic-ui-react';

const ImageCard = ({image}) => (
    <div>
        <Image src={image.path} size="medium" />
        <div>
            <Image src='https://react.semantic-ui.com/images/wireframe/square-image.png' size='mini' circular />
        </div>
        <p>{image.text}</p>
    </div>
);

ImageCard.propTypes = {
    image: ImageType.isRequired,
};

export default ImageCard;
