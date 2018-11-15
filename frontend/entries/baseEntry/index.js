const _ = require("lodash");
const React = require("react");
const ReactDOM = require("react-dom");
const { Provider } = require("react-redux");
const { combineReducers, createStore, applyMiddleware } = require("redux");
const thunk = require("redux-thunk").default;
import { ThemeContext } from "entries/baseEntry/context.js";

function isReactReduxsetup() {
  return window.store;
}

function setupInitialStore() {
  window.store = configureStore();
}

function createReducer(asyncReducers = {}) {
  const reducers = Object.assign(
    {},
    { recentWorks: recentWorksReducer },
    asyncReducers
  );
  return combineReducers(reducers);
}

function configureStore() {
  const initialState = {};
  const store = createStore(
    createReducer({}),
    initialState,
    applyMiddleware(thunk)
  );
  return store;
}

function lazyRenderReactElements(store, scope = document) {
  const nodes = scope.querySelectorAll("[js-react-module]");
  _.forEach(nodes, node => lazyRenderReactElementsAtNode(node, store));
}

function lazyRenderReactElementsAtNode(renderNode, store) {
  const props = getPropsAtNode(renderNode);
  const render = ReactElement => {
    renderReactElementToNode(ReactElement, renderNode, store, props);
  };

  const classPath = getReactElementClassPath(renderNode);

  if (classPath) {
    importReactElement(classPath).then(render);
  }
}

function getPropsAtNode(renderNode) {
  const domElementProps = renderNode.getAttribute("data-react-props");
  return JSON.parse(domElementProps);
}

function getReactElementClassPath(renderNode) {
  return renderNode.getAttribute("js-react-module");
}

function importReactElement(classPath) {
  return import(`modules/${classPath}/index.js`);
}

function initPage(reactElementNodeIds = {}) {
  if (isReactReduxsetup()) {
    window.isReactReduxSettingUp = false;
    return new Promise(resolve => {
      renderEverything(reactElementNodeIds);
      resolve();
    });
  } else if (window.isReactReduxSettingUp) {
    setTimeout(() => initPage(reactElementNodeIds), 10);
  } else {
    window.isReactReduxSettingUp = true;
    return new Promise(resolve => {
      setupInitialStore();
      resolve();
    }).then(() => renderEverything(reactElementNodeIds));
  }
}

function renderEverything(reactElementNodeIds) {
  const { store } = window;
  renderReactElementsToNodeByIds(reactElementNodeIds, store);
  lazyRenderReactElements(store);
}

function renderReactElementsToNodeByIds(elementByNodeIds, store) {
  _.each(elementByNodeIds, (ReactComponent, destinationId) =>
    renderReactElementToNodeById(ReactComponent, destinationId, store)
  );
}

function renderReactElementToNodeById(
  ReactComponent,
  destinationNodeId,
  store
) {
  const destinationNode = document.getElementById(destinationNodeId);
  if (destinationNodeId === null) {
    return null;
  }
  renderReactElementToNode(ReactComponent, destinationNode, store);
}

function renderReactElementToNode(
  ReactComponent,
  destinationNode,
  store,
  props = {}
) {

  if (!destinationNode) {
    return null;
  }

  const WrappedComponent = ReactComponent.default;

  ReactDOM.render(
    <Provider store={store}>
      <ThemeContext.Consumer>
        {
          theme => {
            const contextProps = Object.assign({}, props, theme);
            return <WrappedComponent {...contextProps} />
          }
        }
      </ThemeContext.Consumer>
    </Provider>,
    destinationNode
  );
}

module.exports = {
  initPage
};
