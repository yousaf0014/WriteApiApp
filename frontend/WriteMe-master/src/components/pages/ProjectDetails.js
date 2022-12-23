import React, { Component } from 'react'
import SideBar from "../layouts/SideBar";
import { DropdownButton, Dropdown } from 'react-bootstrap';
import Articles from '../Articles'


const latest=[
    {
        id:"1",
        tittle: "Lattest Tittle 1",
    },
    {
        id:"2",
        tittle: "Lattest Tittle 2",
    },
    {
        id:"3",
        tittle: "Lattest Tittle 3",
    },
    {
        id:"4",
        tittle: "Lattest Tittle 4",
    }
]

const all=[
    {
        id:"1",
        tittle: "All Tittle 1",
    },
    {
        id:"2",
        tittle: "All Tittle 2",
    },
    {
        id:"3",
        tittle: "All Tittle 3",
    },
    {
        id:"4",
        tittle: "All Tittle 4",
    }
]

export class ProjectDetails extends Component {
    constructor(props) {
        super(props);
    
        this.state = {
            list:all
        };
    
        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(e) {
        // Variable to hold the original version of the list
    let currentList = [];
        // Variable to hold the filtered list before putting into state
    let newList = [];
        
        // If the search bar isn't empty
    if (e.target.value !== "") {
            // Assign the original list to currentList
      currentList = all;
            
            // Use .filter() to determine which items should be displayed
            // based on the search terms
      newList = currentList.filter(item => {
                // change current item to lowercase
        const lc = item.tittle.toLowerCase();
                // change search term to lowercase
        const filter = e.target.value.toLowerCase();
                // check to see if the current list item includes the search term
                // If it does, it will be added to newList. Using lowercase eliminates
                // issues with capitalization in search terms and search content
        return lc.includes(filter);
      });
    } else {
            // If the search bar is empty, set newList to original task list
      newList = all;
    }
        // Set the filtered state based on what our rules added to newList
    this.setState({
      list: newList
    });
  }

    render() {
        return (
            <React.Fragment>
            <SideBar selected="none"/>
            <div className="main">
                    <div className="container">
                        <div className="row pt-3 pb-3">
                            <div className="col-md-6 float-left"><h1>Project Tittle</h1></div>
                            <div className="col-md-3 col-lg-4">
                                <div className="search-box rounded border float-right ">
                                    <svg viewBox="0 0 16 16" className="bi bi-search icon" fill="#a183f7" xmlns="http://www.w3.org/2000/svg">
                                        <path fillRule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                        <path fillRule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                    </svg>
                                    <input onChange={this.handleChange} type="text" placeholder="Search for an article"></input>
                                    
                                </div>
                            </div>
                            <div className="col-md-3 col-lg-2">
                            <DropdownButton className="float-right ml-3 mt-0 pt-0"
                                alignRight
                                title="All Categories "
                                id="dropdown-menu-align-right"
                                >
                                <Dropdown.Item eventKey="1">Action</Dropdown.Item>
                                <Dropdown.Item eventKey="2">Another action</Dropdown.Item>
                                <Dropdown.Item eventKey="3">Something else here</Dropdown.Item>
                                <Dropdown.Divider />
                                <Dropdown.Item eventKey="4">Separated link</Dropdown.Item>
                            </DropdownButton>
                            </div>
                        </div>
                        <div className="row pt-3">
                                <div className="col-12 col-sm-6 col-md-4 col-lg-4">
                                    <h4>Latest Articles</h4>
                                </div>
                                <div className="	d-none d-sm-block col-sm-6 col-md-8 col-lg-8">
                                    <hr/>
                                </div>
                        </div>
                        <Articles list={latest}/>
                        <div className="row pt-3">
                                <div className="col-12 col-sm-6 col-md-4 col-lg-4">
                                    <h4>All Articles</h4>
                                </div>
                                <div className="	d-none d-sm-block col-sm-6 col-md-8 col-lg-8">
                                    <hr/>
                                </div>
                        </div>
                        <Articles list={this.state.list}/>
                        
                    </div>
                </div>
        </React.Fragment>
        )
    }
}

export default ProjectDetails
