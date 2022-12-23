import React, { Component } from 'react'

export class Categories extends Component {
    render() {
        return (
            <>
            <div className="row mt-1 p-1">
                    <div className="col-6 col-sm-6 col-md-4 col-lg-4">
                        <h4>Recent Categories</h4>
                    </div>
                    <div className="	d-none d-sm-block col-sm-4 col-md-6 col-lg-7">
                        <hr/>
                    </div>
                    <div className="col-6 col-sm-2 col-md-2 col-lg-1 float-right">
 
                    </div>
            </div>
            <div className="row m-2">
                    <button className="btn btn-primary mx-2 my-1">
                        Health
                    </button>
                    <button className="btn btn-primary mx-2 my-1">
                        Medical
                    </button>
                    <button className="btn btn-primary mx-2 my-1">
                        Technology
                    </button>
                    <button className="btn btn-primary mx-2 my-1">
                        IT
                    </button>
                    <button className="btn btn-primary mx-2 my-1">
                        Robotics
                    </button>
            </div>
                
            </>
        )
    }
}

export default Categories
