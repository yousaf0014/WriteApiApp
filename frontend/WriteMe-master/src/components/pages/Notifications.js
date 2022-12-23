import React, { Component } from 'react'
import Sidebar from '../layouts/SideBar'
import NotificationCard from '../NotificationCard'

const data=[
    {
        id: "1",
        tittle: "The New Era",
        description: "You are required to complete the article.",
        time: "4:16 PM",
    },
    {
        id: "2",
        tittle: "Artificial Technology",
        description: "The shipmenet has arrived.",
        time: "4:16 PM",
    },
    {
        id: "3",
        tittle: ".NET Core",
        description: "The pro account that you ordered has been completed.",
        time: "4:16 PM",
    },
    {
        id: "4",
        tittle: "Flutter",
        description: "Your article is ready.",
        time: "4:16 PM",
    }
];

export class Notifications extends Component {
    constructor(props) {
        super(props);
    
        this.state = {
            list:data
        };
    
        this.removeItem = this.removeItem.bind(this);
    }


    removeItem(item) {
        // Put our list into an array
        const list = this.state.list.slice();
        // Check to see if item passed in matches item in array
        // eslint-disable-next-line
        list.some((el, i) => {
          if (el === item) {
            // If item matches, remove it from array
            list.splice(i, 1);
            return true;
          }
        });
        // Set state to list
        this.setState({
          list: list
        });
      }



    render() {
        return (
            <React.Fragment>
            <Sidebar selected="none"/>
            <div className="main">
                <div className="container">
                    <div className="row pt-3 pb-3">
                        <div className="col float-left"><h1>Notifications</h1></div>
                    </div>
                    {this.state.list.map(item=>(
                        <NotificationCard key={item.id} tittle={item.tittle} description={item.description} toBeDeleted={item} time={item.time} delete={this.removeItem}/>
                    ))}
                </div>
            </div>


        </React.Fragment>
        )
    }
}

export default Notifications
