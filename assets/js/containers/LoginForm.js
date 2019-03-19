import React, {PureComponent} from 'react';
import {connect} from 'react-redux';
import PropTypes from 'prop-types';
import {bindActionCreators} from 'redux';

import {attemptLogin} from '../actions/login';
import Loader from '../components/Loader';
import {Header} from 'semantic-ui-react';

class LoginForm extends PureComponent {
    onSubmit(e) {
        e.preventDefault();

        this.props.attemptLogin(this.usernameRef.value, this.passwordRef.value);
    }

    render() {
        return this.props.authenticated ? null : (
            <>
                <Loader active={this.props.loading}/>

                <Header as='h1'>Login</Header>

                <form onSubmit={this.onSubmit.bind(this)}>
                    {this.props.error && (<div>{this.props.error}</div>)}

                    <input type="email" ref={ref => this.usernameRef = ref}/>
                    <input type="password" ref={ref => this.passwordRef = ref} />

                    <button type="submit" onClick={this.onSubmit.bind(this)}>
                        Login
                    </button>
                </form>
            </>
        );
    }
}

LoginForm.propTypes = {
    attemptLogin:  PropTypes.func.isRequired,
    loading:       PropTypes.bool,
    error:         PropTypes.string,
    authenticated: PropTypes.bool.isRequired,
};

export default connect(
    state => ({
        loading:       state.login.loading,
        error:         state.login.error,
        authenticated: !!state.login.token,
    }),
    dispatch => ({
        attemptLogin: bindActionCreators(attemptLogin, dispatch),
    }),
)(LoginForm);
