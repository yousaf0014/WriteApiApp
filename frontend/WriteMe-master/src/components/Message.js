import React, { Component,useState } from 'react'
import {Alert} from 'react-bootstrap'
import PropTypes from 'prop-types';


export class Message extends Component {
    render() {
        return (
            <>
            <AlertDismissibleExample type={this.props.type} message={this.props.message} />
            </>
        )
    }
}

export default Message

Message.prototypes={
    type: PropTypes.string.isRequired,
    message: PropTypes.string.isRequired
}

function AlertDismissibleExample(obj) {
    const [show, setShow] = useState(true);
    if (show) {
        if (!"success".localeCompare(obj.type))
            return <Alert variant= "alert alert-success" onClose={() => setShow(false)} >
            
            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" className="bi bi-check2 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fillRule="evenodd" d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
            </svg>
    <span className="messageText">{obj.message}</span>
            <button type="button" className="close" onClick={() => setShow(false)} >
                <span aria-hidden="true">&times;</span>
            </button>
        </Alert>
        if (!"danger".localeCompare(obj.type))
        return <Alert variant= "alert alert-danger" onClose={() => setShow(false)} >
        
        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" className="bi bi-x mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fillRule="evenodd" d="M11.854 4.146a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708-.708l7-7a.5.5 0 0 1 .708 0z"/>
            <path fillRule="evenodd" d="M4.146 4.146a.5.5 0 0 0 0 .708l7 7a.5.5 0 0 0 .708-.708l-7-7a.5.5 0 0 0-.708 0z"/>
        </svg>
        <span className="messageText">{obj.message}</span>
        <button type="button" className="close" onClick={() => setShow(false)} >
            <span aria-hidden="true">&times;</span>
        </button>
    </Alert>
    }
    return null;
  }