import {
  Aside,
  Button,
  Container,
  Dialog,
  Dropdown,
  DropdownItem,
  DropdownMenu,
  Form,
  FormItem,
  Header,
  Input,
  Loading,
  Main,
  Menu,
  MenuItem,
  Message,
  MessageBox,
  Submenu,
  Tooltip
} from 'element-ui'

const components = [
  Container,
  Header,
  Aside,
  Menu,
  Submenu,
  MenuItem,
  Main,
  Tooltip,
  Dialog,
  Form,
  FormItem,
  Input,
  Button,
  Dropdown,
  DropdownMenu,
  DropdownItem
]

const ElementUi = {
  install(Vue) {
    components.map(component => {
      Vue.component(component.name, component)
    })

    Vue.use(Loading.directive)

    Vue.prototype.$loading = Loading.service
    Vue.prototype.$alert = MessageBox.alert
    Vue.prototype.$confirm = MessageBox.confirm
    Vue.prototype.$prompt = MessageBox.prompt
    Vue.prototype.$notify = Notification
    Vue.prototype.$message = Message
  }
}

export default ElementUi
