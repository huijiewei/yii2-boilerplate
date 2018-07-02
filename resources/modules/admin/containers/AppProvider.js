import React, { Component } from 'react'
import { Provider } from 'constate'

class AppProvider extends Component {
  onMount = () => {
    const spinner = document.getElementById('spinner')

    if (spinner && !spinner.hasAttribute('hidden')) {
      spinner.setAttribute('hidden', 'true')
    }
  }

  render() {
    return (
      <Provider onMount={this.onMount} {...this.props}>

      </Provider>
    )
  }
}

export default AppProvider
