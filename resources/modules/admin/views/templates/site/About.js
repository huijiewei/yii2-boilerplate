import React, { Fragment } from 'react'
import { Helmet } from 'react-helmet'
import { Link } from '@reach/router'

const About = () => (
  <Fragment>
    <Helmet title={'关于'}/>
    <h2>About</h2>
    <Link to="../">首页</Link>
  </Fragment>
)

export default About
