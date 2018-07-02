import React, { Component } from 'react'
import { Container } from 'constate'

class SiderCollapseContainer extends Component {
  initialState = { collapsed: false }

  actions = {
    collapse: () => state => {
      state.collapsed = !state.collapsed
    },

    onCollapse: (value) => state => {
      state.collapsed = value
    }
  }

  render() {
    return (
      <Container
        initialState={this.initialState}
        actions={this.actions}
        {...this.props}
      />
    )
  }
}

export default SiderCollapseContainer
