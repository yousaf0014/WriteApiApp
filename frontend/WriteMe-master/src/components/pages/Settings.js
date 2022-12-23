import React, { Component } from 'react'
import Avatar from '../../assets/images/Avatar2.png'
import Sidebar from '../layouts/SideBar'
import {Link} from 'react-router-dom'

export class Settings extends Component {
    state={
        name:"Sharjeel Hassan",
        email: "sharjeelhassan2011@gmail.com",
        password:"flkdkjflkjkd"
    }
    render() {
        return (
            <React.Fragment>
                <Sidebar selected="settings"/>
                <div className="main">
                <div className="container">
                    <div className="row pt-3">
                      <div className="col-sm-6 float-left"><h1>Settings</h1></div>
                      <div className="col-sm-6 float-right d-inline">
                        <div className="float-right">
                          <img src={Avatar} className="rounded-circle" alt="Avatar" width="64" height="64"/>
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
                    <div className="row pt-3">
                        <div className="col">
                            <h6>Account Settings</h6>
                        </div>
                    </div>
                    <form className="setting-form">
                    <div className="row pt-3">
                        <div className="col-md-3">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-person-fill float-left grey" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fillRule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                            <h6 className="pl-4 grey">Name</h6>
                        </div>
                        <div className="col-md-9"><input name="name" type="text" value={this.state.name} onChange={e => this.setState({ name: e.target.value })}/></div>
                    </div>
                    <hr/>
                    <div className="row">
                        <div className="col-md-3">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-envelope-fill float-left grey" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                         <path fillRule="evenodd" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                        </svg>
                            <h6 className="pl-4 grey">Email</h6>
                        </div>
                        <div className="col-md-9"><input name="email" type="text" value={this.state.email} onChange={e => this.setState({ email: e.target.value })}/></div>
                    </div>
                    <hr/>
                    <div className="row">
                        <div className="col-md-3">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" className="bi bi-lock-fill float-left grey" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 9a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V9z"/>
                            <path fillRule="evenodd" d="M4.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z"/>
                        </svg>
                            <h6 className="pl-4 grey">Password</h6>
                        </div>
                        <div className="col-md-9"><input name="password" type="password" value={this.state.password} onChange={e => this.setState({ password: e.target.value })}/></div>
                    </div>
                    <hr/>
                    <div className="row">
                        <div className="col-md-3 my-auto">
                        <svg width="15px" height="20px" viewBox="0 0 16 16" className="bi bi-image-fill float-left grey" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fillRule="evenodd" d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094L15.002 9.5V13a1 1 0 0 1-1 1h-12a1 1 0 0 1-1-1v-1zm5-6.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        </svg>
                            <h6 className="pl-4 grey">Display Picture</h6>
                        </div>
                        <div className="col-md-9">
                            <img src={Avatar} className="rounded-circle" alt="Avatar" width="100" height="100"/>
                        </div>
                    </div>
                    <hr/>
                    <div className="row pt-3">
                        <div className="col">
                            <button type="button" className="btn btn-primary">Save Settings</button>
                        </div>
                    </div>
                    </form>
                    <div className="row pt-3">
                        <div className="col">
                            <h6>aMember Pro Settings</h6>
                        </div>
                    </div>
                    <div className="row pt-3">
                        <div className="col">
                            <button type="button" className="btn btn-primary btn-primary-lg">Go to aMember Pro</button>
                        </div>
                    </div>
                    <br/>

                    </div>
               </div>
            </React.Fragment>
        )
    }
}

export default Settings
