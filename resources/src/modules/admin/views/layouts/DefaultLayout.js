import React from 'react'
import { Container, Navbar, NavbarBrand } from 'reactstrap'
import { Link } from 'react-router-dom'

import('@admin/styles/main.css')

class DefaultLayout extends React.Component {
  render() {
    document.body.classList.add('fix-header', 'fix-sidebar')

    return (
      <div className="wrapper">
        <div className="header">
          <Navbar light expand="md">
            <div className="navbar-header">
              <NavbarBrand><Link to="/">Boilerplate</Link></NavbarBrand>
            </div>
          </Navbar>
        </div>
        <div className="sidebar">

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
