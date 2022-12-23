import React, { Component } from 'react'
import Sidebar from '../layouts/SideBar'
import Avatar from '../../assets/images/Avatar2.png'
import Message from '../Message'
import Projects from '../Projects'
import Categories from '../Categories'
import {Link} from 'react-router-dom'


export class Home extends Component {
    render() {
        return (
            <React.Fragment>
                <Sidebar selected="home"/>
                <div className="main">
                  <div className="container">
                    <div className="row pt-3">
                      <div className="col-sm-6 float-left"><h1>Dashboard</h1></div>
                      <div className="col-sm-6 float-right d-inline">
                        <div className="float-right">
                          <Link to="/settings">
                          <img src={Avatar} className="rounded-circle hover-effect" alt="Avatar" width="64" height="64"/>
                          </Link>
                        </div>
                        <div className="pt-3 mr-4 float-right">
                          <svg width="12px" height="12px" viewBox="0 0 16 16" className="bi bi-circle-fill mr-neg-8 mt-neg-10" fill="#fb5660" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="8" cy="8" r="8"/>
                          </svg>
                          <Link to="/notifications">
                            <svg width="25px" height="25px" viewBox="0 0 16 16" className="bi bi-bell-fill hover-effect pl-0 ml-0 " fill="#000000" xmlns="http://www.w3.org/2000/svg">
                              <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z"/>
                            </svg>
                          </Link>
                        </div>
                      </div>
                    </div>
                    <div className="row p-1 mt-4">
                      <div className="col-12">
                        <Message type='success' message="Your profile has been created."/>
                      </div>
                    </div>
                    <Projects/>
                    <Categories/>
                  </div>
                </div>
            </React.Fragment>
        )
    }
    
}


export default Home
