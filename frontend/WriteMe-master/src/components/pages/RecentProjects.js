import React, { Component } from 'react'
import Sidebar from '../layouts/SideBar'
import RecentExpotCard from '../RecentExpotCard'



const data=[
    {
        sr: "1",
        tittle: "The Newhjsdhjshdj Era",
        project: "Technology",
        type: "PDF",
        time: "4:16 PM",
    },
    {
        sr: "2",
        tittle: "Artificial Technology",
        project: "Technology",
        type: "PDF",
        time: "4:16 PM",
    },
    {
        sr: "3",
        tittle: ".NET Core",
        project: "Technology",
        type: "PDF",
        time: "4:16 PM",
    },
    {
        sr: "4",
        tittle: "Flutter",
        project: "Technology",
        type: "PDF",
        time: "4:16 PM",
    }
];

export class RecentProjects extends Component {
    constructor(props) {
        super(props);
    
        this.state = {
            list:data
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
      currentList = data;
            
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
      newList = data;
    }
        // Set the filtered state based on what our rules added to newList
    this.setState({
      list: newList
    });
  }


    render() {
        return (
            <React.Fragment>
                <Sidebar selected="history"/>
                <div className="main">
                    <div className="container">
                        <div className="row pt-3 pb-3">
                            <div className="col float-left"><h1>Recent Exports</h1></div>
                            <div className="col">
                                <div className="search-box border float-right ">
                                    <svg viewBox="0 0 16 16" className="bi bi-search icon" fill="#a183f7" xmlns="http://www.w3.org/2000/svg">
                                        <path fillRule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                        <path fillRule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                    </svg>
                                    <input onChange={this.handleChange} type="text" placeholder="Search for an article"></input>
                                </div>
                            </div>
                        </div>
                        {this.state.list.map(item=>(
                            <RecentExpotCard tittle={item.tittle} key={item.sr} time={item.time} type={item.type} sr={item.sr} project={item.project}/>
                        ))}
                        
                    </div>
                </div>
            </React.Fragment>
        )
    }
}

export default RecentProjects
