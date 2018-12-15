import React from 'react'
import vcCake from 'vc-cake';
const vcvAPI = vcCake.getService('api')

export default class vcExampleComponent extends vcvAPI.elementComponent {

  constructor(props) {
    super(props)
    this.state = {
      logo: window.vcvLogo || ''
    }
  }

  render() {
    const { id, atts, editor } = this.props
    const doAll = this.applyDO('all');

    return <div {...editor} >
      <div className="vce-vc-component" id={'el-' + id}  {...doAll}>
        <div>{this.state.logo}</div>
      </div>
    </div>
  }
}
