import React from 'react'
import PropTypes from 'prop-types'
import { Icon, Layout, Menu } from 'antd'
import Logo from '@admin/assets/images/logo.png'
import Banner from '@admin/assets/images/banner.png'

import styles from '@admin/styles/main.scss'
import Scrollbars from 'react-custom-scrollbars'
import { Link } from '@reach/router'

const { SubMenu } = Menu
const { Header, Content, Sider } = Layout

class DefaultLayout extends React.Component {
  static propTypes = {
    children: PropTypes.node
  }

  render() {
    return (
      <Layout className="bp-root" hasSider={true} style={{ minHeight: '100vh' }}>
        <Sider
          collapsible
          trigger={null}
          collapsedWidth={styles['bp-sider-collapsed-width']}
          width={styles['bp-sider-width']}
          className="bp-sider"
          breakpoint="lg"
          theme={'light'}>
          <div className="bp-logo">
            <img className="logo" height="50" src={Logo}/>
            <img className="banner" height="50" src={Banner}/>
          </div>
          <Scrollbars style={{ height: 'calc(100vh - ' + styles['bp-header-height'] + ')' }} autoHide={true}>
            <Menu defaultOpenKeys={['m1']} defaultSelectedKeys={['m1', 's13']} mode={'inline'} theme={'light'}>
              <SubMenu
                popupOffset={[2, 2]} key="m1"
                title={<span className={'menu-title'}><Icon type="home"/><span
                  className={'menu-title-text'}>首页</span></span>}>
                <Menu.Item key="s11" active><Link to="./">首页</Link></Menu.Item>
                <Menu.Item key="s12"><Link to="./about">关于</Link></Menu.Item>
                <Menu.Item key="s13">option3</Menu.Item>
                <Menu.Item key="s14">option4</Menu.Item>
              </SubMenu>

              <SubMenu
                popupOffset={[2, 2]} key="m2"
                title={<span className={'menu-title'}><Icon type="user"/><span
                  className={'menu-title-text'}>用户</span></span>}>
                <Menu.Item key="s21" active>option1</Menu.Item>
                <Menu.Item key="s22">option2</Menu.Item>
                <Menu.Item key="s23">option3</Menu.Item>
                <Menu.Item key="s24">option4</Menu.Item>
              </SubMenu>

              <Menu.Item key="3">nav 3</Menu.Item>
            </Menu>
          </Scrollbars>
        </Sider>
        <Layout className="bp-layout">
          <Header className="bp-header">
            头部
          </Header>
          <Content className="bp-content">
            {this.props.children}
          </Content>
        </Layout>
      </Layout>
    )
  }
}

export default DefaultLayout
