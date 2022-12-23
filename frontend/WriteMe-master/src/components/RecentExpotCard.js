import React, { Component } from 'react'
import PropTypes from 'prop-types';


export class RecentExpotCard extends Component {
    render() {
        return (
            <div className="row pt-3">
                            <div className="col-sm-12">
                                <div className="card history">
                                    <div className="row">
                                        <div className="col-6 ">
                                            <h2>{this.props.sr}</h2>
                                            <div className="divider"></div>
                                            <div className="float-left">
                                                <h3>{this.props.tittle}</h3>
                                                <p>{this.props.project}</p>
                                            </div>
                                        </div>
                                        <div className="col-6">
                                            <h6>{this.props.time}</h6>
                                            <div className="divider float-right"></div>
                                            <h6>{this.props.type}</h6>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
        )
    }
}
// PropTypes
RecentExpotCard.propTypes = {
    tittle: PropTypes.string.isRequired,
    project: PropTypes.string.isRequired,
    time: PropTypes.string.isRequired,
    type: PropTypes.string.isRequired,
    sr: PropTypes.string.isRequired
  }

export default RecentExpotCard
