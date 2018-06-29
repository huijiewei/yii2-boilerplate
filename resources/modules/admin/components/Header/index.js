import React, { Component } from 'react'

import { Icon, Layout } from 'antd'
import SiderCollapseContainer from '@admin/containers/SiderCollapseContainer'

import './index.scss'

class Header extends Component {
  render() {
    return (
      <Layout.Header className="bp-header">
        <SiderCollapseContainer context="siderCollapse">
          {({ collapsed, collapse }) => <Icon
            className="trigger"
            type={collapsed ? 'menu-unfold' : 'menu-fold'}
            onClick={collapse}
          />}
        </SiderCollapseContainer>
      </Layout.Header>
    )
  }
}

export default Header
