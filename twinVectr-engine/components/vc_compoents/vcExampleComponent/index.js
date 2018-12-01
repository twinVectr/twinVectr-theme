import vcCake from 'vc-cake'
import vcExampleComponent from './component'

const vcvAddElement = vcCake.getService('cook').add

vcvAddElement(
  require('./settings.json'),
  // Component callback
  function (component) {
    component.add(vcExampleComponent)
  },
  // css settings // css for element
  {
    css: false,
    editorCss: require('raw-loader!./editor.css'),
    // cssMixins: {
    //   boilerplateColorMixin: {
    //     mixin: require('raw-loader!./cssMixins/boilerplateColorMixin.pcss')
    //   }
    // }
  }
)
