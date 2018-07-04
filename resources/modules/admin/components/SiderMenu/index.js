import React, { Component } from 'react'
import { Icon, Menu } from 'antd'

import { Link } from '@reach/router'
import apiClient from '@admin/utils/ApiClient'

class SiderMenu extends Component {
  state = {
    menus: []
  }

  componentDidMount() {
    apiClient.get('site/menus').then(data => this.setState({ menus: data }))
  }

  generateMenuPartitions(menus) {
    return menus.map(menu => {
      if (menu.children) {
        let subMenuTitle = (
          <span className="menu-title">
            {menu.icon && <Icon type={menu.icon}/>}
            <span className="menu-title-label">{menu.label}</span>
          </span>
        )
        return (
          <Menu.SubMenu key={'m-' + menu.url.replace('/', '-')} title={subMenuTitle}>
            {this.generateMenuPartitions(menu.children)}
          </Menu.SubMenu>
        )
      }

      return SiderMenu.generateMenuItem(menu)
    })
  }

  static generateMenuItem(item) {
    return (
      <Menu.Item key={'s-' + item.url.replace('/', '-')}>
        <Link to={'./' + item.url}>
          {item.icon && <Icon type={item.icon}/>}
          <span className="menu-title">{item.label}</span>
        </Link>
      </Menu.Item>
    )
  }

  render() {
    return (
      <Menu mode={'inline'} theme={'light'}>
        {this.generateMenuPartitions(this.state.menus)}
      </Menu>
    )
  }
}

export default SiderMenu
