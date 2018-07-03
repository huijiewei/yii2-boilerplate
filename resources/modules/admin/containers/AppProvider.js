import React, { Component } from 'react'
import { Provider } from 'constate'

class AppProvider extends Component {
  onMount = () => {

  }

  render() {
    return (
      <Provider onMount={this.onMount} {...this.props}/>
    )
  }
}

export default AppProvider
