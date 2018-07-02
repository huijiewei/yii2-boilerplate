import React, { Component } from 'react'
import { Icon, Menu } from 'antd'
import { Link } from '@reach/router'

const { SubMenu, Item } = Menu

class SiderMenu extends Component {
  render() {
    return (
      <Menu defaultOpenKeys={['m1']} defaultSelectedKeys={['m1', 's13']} mode={'inline'} theme={'light'}>
        <SubMenu
          popupOffset={[2, 2]} key="m1"
          title={<span className={'menu-title'}><Icon type="home"/><span
            className={'menu-title-text'}>首页</span></span>}>
          <Item key="s11" active><Link to="./">首页</Link></Item>
          <Item key="s12"><Link to="./about">关于</Link></Item>
          <Item key="s13">option3</Item>
          <Item key="s14">option4</Item>
        </SubMenu>

        <SubMenu
          popupOffset={[2, 2]} key="m2"
          title={<span className={'menu-title'}><Icon type="user"/><span
            className={'menu-title-text'}>用户</span></span>}>
          <Item key="s21" active>option1</Item>
          <Item key="s22">option2</Item>
          <Item key="s23">option3</Item>
          <Item key="s24">option4</Item>
        </SubMenu>

        <Item key="3">nav 3</Item>
      </Menu>
    )
  }
}

export default SiderMenu
