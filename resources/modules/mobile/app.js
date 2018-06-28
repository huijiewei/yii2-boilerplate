import React, { Fragment, StrictMode } from 'react'
import ReactDOM from 'react-dom'
import classNames from 'classnames'
import { Router } from '@reach/router'
import { Helmet } from 'react-helmet'

import './styles/main.scss'

class App extends React.Component {
  render() {
    return (
      <StrictMode>
        <Fragment>
          <Helmet titleTemplate={'%s - ' + document.title}/>
          {(params) => (
            <div className={classNames(params)}>
              <Router basepath="/mobile">
              </Router>
            </div>
          )}
        </Fragment>
      </StrictMode>
    )
  }
}

ReactDOM.render(
  <App/>,
  document.getElementById('root')
)
