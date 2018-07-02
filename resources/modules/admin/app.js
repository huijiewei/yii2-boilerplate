import React, { Component, Fragment } from 'react'
import Loadable from 'react-loadable'
import ReactDOM from 'react-dom'
import { Router } from '@reach/router'
import { Helmet } from 'react-helmet'
import zh_CN from 'antd/lib/locale-provider/zh_CN'
import { LocaleProvider } from 'antd'
import { ContainerQuery } from 'react-container-query'
import classNames from 'classnames'
import Home from '@admin/views/templates/site/Home'
import DefaultLayout from '@admin/views/layouts/DefaultLayout'
import AppProvider from '@admin/containers/AppProvider'

const Loading = () => <div>Loading...</div>

const LoadableAbout = Loadable({
  loader: () => import(/* webpackChunkName: "about" */ '@admin/views/templates/site/About'),
  loading: Loading
})

const containerQuery = {
  'screen-xs': {
    maxWidth: 575
  },
  'screen-sm': {
    minWidth: 576,
    maxWidth: 767
  },
  'screen-md': {
    minWidth: 768,
    maxWidth: 991
  },
  'screen-lg': {
    minWidth: 992,
    maxWidth: 1199
  },
  'screen-xl': {
    minWidth: 1200,
    maxWidth: 1599
  },
  'screen-xxl': {
    minWidth: 1600
  }
}

const mobileQuery = 'only screen and (max-width: 767.99px)'

const NotFound = () => <p>Sorry, nothing here</p>

class App extends Component {
  render() {
    return (
      <AppProvider devtools>
        <LocaleProvider locale={zh_CN}>
          <Fragment>
            <Helmet titleTemplate={'%s - ' + document.title}/>
            <ContainerQuery query={containerQuery}>
              {(params) => (
                <div className={classNames(params)}>
                  <Router basepath="/admin">
                    <DefaultLayout path="/">
                      <Home path="/"/>
                      <LoadableAbout path="about"/>
                      <NotFound default/>
                    </DefaultLayout>
                  </Router>
                </div>
              )}
            </ContainerQuery>
          </Fragment>
        </LocaleProvider>
      </AppProvider>
    )
  }
}

ReactDOM.render(
  <App/>,
  document.getElementById('root')
)
