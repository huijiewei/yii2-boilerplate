import React from 'react'
import { Container, Navbar, NavbarBrand } from 'reactstrap'
import { Link } from 'react-router-dom'
import imageLogo from '@admin/assets/images/logo.png'
import imageBanner from '@admin/assets/images/banner.png'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'

import { faTachometerAlt } from '@fortawesome/free-solid-svg-icons'

import('@admin/styles/main.css')

library.add(faTachometerAlt)

class DefaultLayout extends React.Component {
  render() {
    document.body.classList.add('fix-header', 'fix-sidebar')

    return (
      <div className="wrapper">
        <div className="header">
          <Navbar light expand="md">
            <div className="navbar-header">
              <NavbarBrand tag={Link} to={'/'}>
                <strong><img height={50} src={imageLogo}/></strong>
                <span><img height={50} src={imageBanner}/></span>
              </NavbarBrand>
            </div>
          </Navbar>
        </div>
        <div className="sidebar">
          <nav className="sidebar-nav">
            <ul className="in">
              <li className="nav-divider"/>
              <li className="nav-label">
                首页
              </li>
              <li className="active">
                <Link to="/" className="has-arrow" aria-expanded={'false'}>
                  <i>
                    <FontAwesomeIcon icon={'tachometer-alt'}/>
                  </i>
                  <span className="hide-menu">后台首页</span>
                </Link>
              </li>
            </ul>
          </nav>
        </div>
        <div className="body">
          <Container fluid>
          </Container>
        </div>
      </div>
    )
  }
}


export default DefaultLayout
