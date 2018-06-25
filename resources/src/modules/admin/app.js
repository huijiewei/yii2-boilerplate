import React from 'react'
import ReactDOM from 'react-dom'
import Loadable from 'react-loadable'

import { BrowserRouter as Router, Route, Switch } from 'react-router-dom'

import DefaultLayout from '@admin/views/layouts/DefaultLayout'

const Loading = () => <div>Loading...</div>

const LoadableAbout = Loadable({
  loader: () => import(/* webpackChunkName: "admin/about" */ '@admin/components/About'),
  loading: Loading
})


const App = () => (
  <Router basename="/admin">
    <Switch>
      <Route path="/about" component={LoadableAbout}/>
      <Route exact path="/" component={DefaultLayout}/>
    </Switch>
  </Router>
)

ReactDOM.render(
  <App/>,
  document.getElementById('root')
)
