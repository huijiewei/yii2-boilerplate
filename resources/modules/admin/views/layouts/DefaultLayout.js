import React, { PureComponent } from 'react'
import PropTypes from 'prop-types'
import { Layout } from 'antd'

import Header from '@admin/components/Header'
import Sider from '@admin/components/Sider'

import '@admin/styles/main.scss'

const { Content } = Layout

class DefaultLayout extends PureComponent {
  static propTypes = {
    children: PropTypes.node
  }

  render() {
    return (
      <Layout hasSider={true} style={{ minHeight: '100vh' }}>
        <Sider/>
        <Layout>
          <Header/>
          <Content>
            {this.props.children}
          </Content>
        </Layout>
      </Layout>
    )
  }
}

export default DefaultLayout
