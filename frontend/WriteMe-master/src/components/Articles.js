import React, { Component } from 'react'
import {ArticleDropdown} from '../components/ArticleDropdown'


export class Articles extends Component {
    render() {
        return (
            <div className="row p-2">
                    {this.props.list.map(item=>(
                        <div className="col-12 col-sm-6 col-md-4  col-lg-3" key={item.id}>
                            <div className="card article m-2" >
                                <div className="card-body d-flex justify-content-center">
                                    <h5 className="card-title">{item.tittle}</h5>
                                </div>
                            </div>
                            <ArticleDropdown/>
                        </div>
                    ))}
                </div>
        )
    }
}

export default Articles
