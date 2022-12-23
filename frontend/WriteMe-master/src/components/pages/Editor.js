import React, { Component } from 'react'
import Sidebar from '../layouts/SideBar'
import {MyEditor} from '../MyEditor'

export class Editor extends Component {
    render() {
        return (
            <React.Fragment>
                <Sidebar selected="edit"/>
                <div className="main">
                    <div className="container">
                        <div className='row pt-3'>
                            <div className="col">
                                <div className="editor-project-tittle">A Medical Journal /</div>
                            </div>
                        </div>
                        <div className='row'>
                            <div className="col-sm-12 col-lg-8">
                                <div className="editor-article-tittle">Why jogging is good for health.</div>
                            </div>
                            <div className="col-sm-12 col-lg-4">
                                <div className="opacity-6 pt-4">
                                    Text Assistant
                                </div>
                            </div>
                        </div>
                        <div className='row pt-3'>
                            <div className="col-sm-12 col-lg-8">
                                <h4>Suggested Keywords</h4>
                                <div className="row mt-3">
                                    <div className="col">
                                    <button className="btn btn-primary mr-3 my-1">
                                        Health
                                    </button>
                                    <button className="btn btn-primary mr-3 my-1">
                                        Running
                                    </button>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4">
                            <div className="card history max-w-250">
                                <div className="row">
                                    <div className="col-7">
                                        <div className="float-left pt-3">
                                            <p className="mb-0 mt-2">Overall Score</p>
                                            <p className="mt-0">See Performance</p>
                                        </div>
                                    </div>
                                    <div className="col-5">
                                        <div className="divider"></div>
                                        <h2 className="">64</h2>
                                    </div>
                                </div>
                                
                            </div>
                            </div>
                        </div>
                        <MyEditor/>
                        

                    </div>
                </div>
                <div className="editer-footer"></div>
            </React.Fragment>
        )
    }
}

export default Editor
