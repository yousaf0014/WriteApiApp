import React from 'react';
import {BrowserRouter as Router,Route} from 'react-router-dom';
import Home from './components/pages/Home';
import RecentProjects from './components/pages/RecentProjects';
import Editor from './components/pages/Editor';
import Settings from './components/pages/Settings';
import Notifications from './components/pages/Notifications';
import ProjectDetails from './components/pages/ProjectDetails'



function App() {
  return (
      <Router>
        <Route exact path="/" render= {props=>(
          <>
            <Home/>
          </>
        )}>
        </Route>
        <Route path="/recentProjects" render= {props=>(
          <>
            <RecentProjects/>
          </>
        )}>
        </Route>
        <Route path="/editor" render= {props=>(
          <>
            <Editor/>
          </>
        )}>
        </Route>
        <Route path="/settings" render= {props=>(
          <>
            <Settings/>
          </>
        )}>
        </Route>
        <Route path="/notifications" render= {props=>(
          <>
            <Notifications/>
          </>
        )}>
        </Route>
        <Route path="/projectdetails" render= {props=>(
          <>
            <ProjectDetails/>
          </>
        )}>
        </Route>

      </Router>
  );
}

export default App;
