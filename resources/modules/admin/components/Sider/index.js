import React, { Component } from 'react'
import Scrollbars from 'react-custom-scrollbars'
import SiderCollapseContainer from '@admin/containers/SiderCollapseContainer'
import SiderMenu from '@admin/components/SiderMenu'
import SiderLogo from '@admin/components/SiderLogo'

import styles from './index.scss'

import { Layout as AntLayout } from 'antd'

const AntSider = AntLayout.Sider

class Sider extends Component {
  render() {
    return (
      <SiderCollapseContainer context="siderCollapse">
        {({ collapsed, onCollapse }) => <AntSider
          className="bp-sider"
          collapsible={true}
          collapsed={collapsed}
          onCollapse={onCollapse}
          trigger={null}
          collapsedWidth={styles['bp-sider-collapsed-width']}
          width={styles['bp-sider-width']}
          breakpoint="lg"
          theme={'light'}>
          <SiderLogo/>
          <Scrollbars style={{ height: 'calc(100vh - ' + styles['bp-header-height'] + ')' }} autoHide={true}>
            <SiderMenu/>
          </Scrollbars>
        </AntSider>}
      </SiderCollapseContainer>
    )
  }
}

export default Sider
