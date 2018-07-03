import React, { Component } from 'react'

import { Icon, Layout as AntLayout } from 'antd'
import SiderCollapseContainer from '@admin/containers/SiderCollapseContainer'

import './index.scss'

const AntHeader = AntLayout.Header

class Header extends Component {
  render() {
    return (
      <AntHeader className="bp-header">
        <SiderCollapseContainer context="siderCollapse">
          {({ collapsed, collapse }) => <Icon
            className="trigger"
            type={collapsed ? 'menu-unfold' : 'menu-fold'}
            onClick={collapse}
          />}
        </SiderCollapseContainer>
      </AntHeader>
    )
  }
}

export default Header
