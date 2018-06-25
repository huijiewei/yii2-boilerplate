import React from 'react'
import ReactDOM from 'react-dom'
import Loadable from 'react-loadable'

import styled from 'styled-components'
import { BrowserRouter as Router, Link, Route, Switch } from 'react-router-dom'

const Title = styled.h2`
  color: red;
`

const Loading = () => <div>Loading...</div>

const LoadableAbout = Loadable({
  loader: () => import(/* webpackChunkName: "admin/about" */ '@admin/components/About'),
  loading: Loading
})

class Home extends React.Component {
  render() {
    return (<div>
      <Title>Home</Title>
    </div>)
  }
}


const App = () => (
  <Router basename="/admin">
    <div>
      <ul>
        <li><Link to="/">Home</Link></li>
        <li><Link to="/about">About</Link></li>
      </ul>

      <hr/>
      <Switch>
        <Route exact path="/" component={Home}/>
        <Route path="/about" component={LoadableAbout}/>
      </Switch>
    </div>
  </Router>
)

ReactDOM.render(
  <App/>,
  document.getElementById('app')
)
