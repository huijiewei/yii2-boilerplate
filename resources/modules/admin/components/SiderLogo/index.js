import React, { Component } from 'react'
import Logo from '@admin/assets/images/logo.png'
import Banner from '@admin/assets/images/banner.png'

class SiderLogo extends Component {
  render() {
    return (
      <div className="bp-logo">
        <img alt="" className="logo" height="50" src={Logo}/>
        <img alt="" className="banner" height="50" src={Banner}/>
      </div>
    )
  }
}

export default SiderLogo
