import React, { Component } from 'react'
import card1 from '../assets/images/Card 1.png'
import card2 from '../assets/images/Card 2.png'
import card3 from '../assets/images/Card 3.png'
import { Link } from 'react-router-dom'
import {ProjectDropdown} from '../components/ProjectDropdown'


export class Projects extends Component {
    render() {
        return (
            <>
                <div className="row mt-1 p-1">
                    <div className="col-6 col-sm-6 col-md-4 col-lg-4">
                        <h4>Your Projects</h4>
                    </div>
                    <div className="	d-none d-sm-block col-sm-4 col-md-6 col-lg-7">
                        <hr/>
                    </div>
                    <div className="col-6 col-sm-2 col-md-2 col-lg-1 float-right">
                    <svg width="25px" height="25px" viewBox="0 0 16 16" className="bi bi-grid-fill hover-effect float-right" fill="#A183F7" xmlns="http://www.w3.org/2000/svg">
                        <path fillRule="evenodd" d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3z"/>
                    </svg>
                    </div>
                </div>
                <div className="row p-2">
                    <div className="col-12 col-sm-6 col-md-4  col-lg-3">
                    
                        <Link to="/projectdetails">
                        <div className="card m-2" >
                        
                        <img className="card-img-top" src={card3} alt="Card"/>
                            <div className="card-body">
                                <h5 className="card-title">Card title</h5>
                                <p className="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                        </Link>
                        <ProjectDropdown/>
                    </div>
                    <div className="col-12 col-sm-6 col-md-4  col-lg-3">
                    <div className="card m-2" >
                        <img className="card-img-top" src={card1} alt="Card"/>
                            <div className="card-body">
                                <h5 className="card-title">Card title</h5>
                                <p className="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                        <ProjectDropdown/>
                    </div>
                    <div className="col-12 col-sm-6 col-md-4  col-lg-3">
                    <div className="card m-2" >
                        <img className="card-img-top" src={card2} alt="Card"/>
                            <div className="card-body">
                                <h5 className="card-title">Card title</h5>
                                <p className="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                        <ProjectDropdown/>
                    </div>
                    
                    <div className="col-12 col-sm-6 col-md-4  col-lg-3">
                    <div className="card m-2" >
                        <img className="card-img-top" src={card3} alt="Card"/>
                            <div className="card-body">
                                <h5 className="card-title">Card title</h5>
                                <p className="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            </div>
                        </div>
                        <ProjectDropdown/>
                    </div>
                </div>
            </>
        )
    }
}

export default Projects
