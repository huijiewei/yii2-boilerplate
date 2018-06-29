import React from 'react'
import { Container } from 'constate'

class SiderCollapseContainer extends React.Component {
  initialState = { collapsed: true }

  actions = {
    collapse: () => state => {
      state.collapsed = !state.collapsed
    },
    onCollapse: (value, type) => state => {
      if (type === 'responsive' && state.collapsed === value) {
        return
      }

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
