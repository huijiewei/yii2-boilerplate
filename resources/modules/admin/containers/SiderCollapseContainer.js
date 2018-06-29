import React from 'react'
import { Container } from 'constate'

const initialState = { collapsed: false }

const actions = {
  collapse: () => state => ({ collapsed: !state.collapsed })
}

const SiderCollapseContainer = props => (
  <Container
    initialState={initialState}
    actions={actions}
    {...props}
  />
)

export default SiderCollapseContainer
