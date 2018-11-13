<?php

namespace twinVectr\engine;

class BehaviorShortcode extends \twinVectr\engine\Behavior {

  // Shortcode key
  public $Shortcode;

  
  function __construct($componentInstance) {
    // Basic Validation
    if(!$this->Shortcode) {
      // Log
      //\Evoke\Core\Theme::$Instance->logError('Component: '. $componentInstance->Name .', Behavior: '. $this->Name .' (BehaviorShortcode) - "Shortcode" prop must be set.');
    }

    // Base constructor
    parent::__construct($componentInstance);
  }

  /**
   * Add Wordpress shortcode
   *
   * Validate shortcode name first
   *
   * @override
   *
   * @param string $shortcodeName Name of the shortcode
   * @param string|array $callback Wordpress render callback
   */
  protected function addShortcode($shortcodeName, $callback) {
    // Basic Validation
    if($this->Shortcode != $shortcodeName) {
      // Log
      //\Evoke\Core\Theme::$Instance->logError('Component: '. $this->_compoment->Name .', Behavior: '. $this->Name .' (BehaviorShortcode) - "shortcodeName" parameter passed into the addFilter() method must be equal to Behavior\'s "Shortcode" prop.');
      return;
    }

    add_shortcode($shortcodeName, $callback);
  }

}


?>
