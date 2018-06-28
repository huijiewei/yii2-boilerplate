import React, { Fragment } from 'react'
import { Helmet } from 'react-helmet'
import { Link } from '@reach/router'

const Home = () => (
  <Fragment>
    <Helmet title={'主页'}/>
    <h2>Home</h2>
    <Link to="./about">关于</Link>
  </Fragment>
)

export default Home
