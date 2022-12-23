import React, { Component } from 'react'
import PropTypes from 'prop-types';


export class NotificationCard extends Component {
    render() {
        return (
            <div className="row mt-3 position-relative">
                
                            <div className="col-sm-12">
                                <div className="card history mt-2">
                                
                                    <div className="row">
                                        <div className="col-6">
                                            <div className="float-left">
                                                <h3>{this.props.tittle}</h3>
                                                <p>{this.props.description}</p>
                                            </div>
                                        </div>
                                        <div className="col-6">
                                            <h6>{this.props.time}</h6>
                                            <div className="divider float-right"></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <button type="button" onClick={() => this.props.delete(this.props.toBeDeleted)} className="btn btn-circle-close position-absolute t-0 r-5">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
        )
    }
}

// PropTypes
NotificationCard.propTypes = {
    tittle: PropTypes.string.isRequired,
    time: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
    delete : PropTypes.func.isRequired,
    toBeDeleted: PropTypes.any.isRequired
  }

export default NotificationCard
