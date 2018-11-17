<?php

namespace twinVectr\engine;
  /**
   * Base Evoke Behavior class
   */
class Behavior {

  // Behavior Basic Props
  // Virtual props
  public $Name;
  public $Desc;


  // Component instance
  protected $compoment;


  function __construct($componentInstance) {
    // Updated component instance
    $this->_compoment = $componentInstance;

    // Basic Validation
    if(!$this->Name || !$this->Desc) {
      // Defaults
      $this->Name = 'Unknown Action';
      $this->Desc = 'Missing Description';

      // Log
      //\Evoke\Core\Theme::$Instance->logError('Component: '. $componentInstance->Name . ', Behavior:Unknown - Virtual props "Name" and "Desc" must be set in derived class.');
    }

    // If there are any required plugins
    // And this is the development mode
    if(\Evoke\Core\Theme::$Instance->Development && sizeof($this->RequiredPlugins) > 0){
      $this->_compoment->checkRequiredPlugins($this->RequiredPlugins, $this);
    }
  }


  /**
   * Function called when the behavior is registered by component
   *
   * Virtual function
   */
  public function register() {
    // Log
    //\Evoke\Core\Theme::$Instance->logWarning('Component: '. $componentInstance->Name .', Behavior: '. $this->Name .' (Behavior) - register() Virtual Render Register must be set in derived class.');
  }

  /**
   * Try to get an usage info - Optional
   *
   * It should a text information how to use this component behavior
   */
  public function getUsageInfo() {
    return $this->_usage;
  }

  /**
   * Returns component instance
   *
   * @return Evoke\Components\Abstraction\Component
   */
  public function getComponent() {
    return $this->_compoment;
  }

  /**
   * Add Wordpress shortcode
   *
   * Resolved on the base component
   *
   * @param string $shortcodeName Name of the shortcode
   * @param string|array $callback Wordpress render callback
   */
  protected function addShortcode($shortcodeName, $callback) {
    // Adds a hook for a shortcode tag
    $this->_compoment->addShortcode($shortcodeName, $callback);
  }

  /**
   * Add Wordpress action hook
   *
   * Resolved on the base component
   *
   * @param string $actionHookName Name of the hook action
   * @param string|array $callback Wordpress callback
   * @param int $priority Used to specify the order in which the functions associated with a particular action are executed
   * @param int $acceptedArgs The number of arguments the function accepts
   */
  protected function addAction($actionHookName, $callback, $priority = 10, $acceptedArgs = 1) {
    // Adds a hook for a shortcode tag
    $this->_compoment->addAction($actionHookName, $callback, $priority, $acceptedArgs);
  }

  /**
   * Add Wordpress filter hook
   *
   * Resolved on the base component
   *
   * @param string $actionHookName Name of the hook action
   * @param string|array $callback Wordpress callback
   * @param int $priority Used to specify the order in which the functions associated with a particular action are executed
   * @param int $acceptedArgs The number of arguments the function accepts
   */
  protected function addFilter($filterHookName, $callback, $priority = 10, $acceptedArgs = 1) {
    // Adds a hook for a shortcode tag
    $this->_compoment->addFilter($filterHookName, $callback, $priority, $acceptedArgs);
  }

  /**
   * Add JS Localization
   *
   * @param array $resources Array of localization string ('key' => 'value')
   */
  protected function addJsLocalization($resources) {
    $this->_compoment->addJsLocalization($resources);
  }
  
  /**
   * Tries to get a component's loaded behavior instance
   *
   * @param string $behaviorName Expected loaded behavior name
   * @param boolean $required If behavior is not found it will log an error (Default: false)
   * @return null|\Evoke\Components\Abstraction\Behavior
   */
  public function getComponentLoadedBehavior($behaviorName, $required = true){
    // Loaded behavior
    $loadedBehavior = $this->_compoment->getLoadedBehaviorInstance($behaviorName);

    // If behavior is loaded
    if($loadedBehavior) {
      return $loadedBehavior;
    }

    // If the behavior is required, log an error
    if($required) {
      //\EHS\Core\Theme::$Instance->logError('Component: ' . $this->_compoment->Name . ', Behavior: '. $this->Name .' requires the behavior '. $behaviorName . '.');
    }

    return null;
  }
}


?>
