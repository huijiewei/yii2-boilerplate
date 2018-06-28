import React from 'react'
import OnokumusMetisMenu from 'metismenu'
import PropTypes from 'prop-types'

import 'metismenu/dist/metisMenu.min.css'

class MetisMenu extends React.Component {
  static propTypes = {
    children: PropTypes.node.isRequired,
    className: PropTypes.string,
    option: PropTypes.object,
    containerRef: PropTypes.func

  }

  static defaultProps = {
    className: '',
    option: {
      subMenu: 'ul.sub-menu'
    },
    containerRef: () => {
    }
  }

  constructor(props) {
    super(props)
  }

  componentDidMount() {
    this.mm = new OnokumusMetisMenu(this._container, this.props.option)

  }

  componentDidUpdate() {
    this.mm.update()
  }

  componentWillUnmount() {
    this.mm.dispose()
  }

  handleRef = (ref) => {
    this._container = ref
    this.props.containerRef(ref)
  }

  render() {
    const { children, className } = this.props
    return (
      <ul className={`metismenu ${className}`} ref={this.handleRef}>
        {children}
      </ul>
    )
  }
}

export default MetisMenu
