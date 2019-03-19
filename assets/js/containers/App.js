import React, {PureComponent} from 'react';
import {connect} from 'react-redux';
import {Container, Header, Menu} from 'semantic-ui-react';
import PropTypes from 'prop-types';

import ImageList from './ImageList';
import LoginForm from './LoginForm';
import UserImageList from './UserImageList';
import {BrowserRouter, Link, Route} from 'react-router-dom';

class App extends PureComponent {
    render() {
        return (
            <BrowserRouter>
                <Container style={{marginTop: '3em'}}>
                    <Menu fixed="top">
                        <Menu.Item header>IUTagram</Menu.Item>
                        <Menu.Item name='photos'/>
                        {this.props.username && <Menu.Item name={this.props.username}/>}
                    </Menu>

                    <ul>
                        <li><Link to="/">Home</Link></li>
                        <li><Link to="/me">Moi</Link></li>
                    </ul>

                    <LoginForm/>

                    <Route exact path="/" render={() => <ImageList/>}/>
                    <Route exact path="/me" render={() => <UserImageList/>}/>

                </Container>
            </BrowserRouter>
        );
    }
}

App.propTypes = {
    username:      PropTypes.string,
    authenticated: PropTypes.bool.isRequired,
};

export default connect(
    state => ({
        authenticated: !!state.login.token,
        username:      state.login.token ? state.login.token.payload.username : null,
    }),
    dispatch => ({}),
)(App);
