import React, { PureComponent } from 'react'
import PropTypes from 'prop-types'
import { Layout as AntLayout } from 'antd'

import Header from '@admin/components/Header'
import Sider from '@admin/components/Sider'

import styles from '@admin/styles/main.scss'
import { Scrollbars } from 'react-custom-scrollbars'

const AntContent = AntLayout.Content

class DefaultLayout extends PureComponent {
  static propTypes = {
    children: PropTypes.node
  }

  render() {
    return (
      <AntLayout hasSider={true} style={{ height: '100vh' }}>
        <Sider/>
        <AntLayout>
          <Header/>
          <AntContent className="bp-content">
            <Scrollbars style={{ height: 'calc(100vh - ' + styles['bp-header-height'] + ')' }} autoHide={false}>
              <div className="bp-content-main">
                {this.props.children}
              </div>
            </Scrollbars>
          </AntContent>
        </AntLayout>
      </AntLayout>
    )
  }
}

export default DefaultLayout
