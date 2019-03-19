import React from 'react';
import {Dimmer, Loader} from 'semantic-ui-react';

export default ({active}) => (
    active && <Dimmer active>
        <Loader size='massive'>Chargement…</Loader>
    </Dimmer>
)
