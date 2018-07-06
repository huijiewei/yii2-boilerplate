import { Aside, Container, Header, Main, Menu, MenuItem, Submenu } from 'element-ui'

const components = [
  Container,
  Header,
  Aside,
  Menu,
  Submenu,
  MenuItem,
  Main
]

const ElementUi = {
  install(Vue) {
    components.map(component => {
      Vue.component(component.name, component)
    })
  }
}

export default ElementUi
