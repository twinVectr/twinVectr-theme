<?php

/**
 * Base Shortcode Behavior class
 */
class BehaviorShortcodeRegistration extends \twinVectr\engine\BehaviorShortcode {

  public $Name = 'Shortcode Registration';
  public $Desc = 'Register Example Shortcode';

  // Shortcode key
  // @override
  public $Shortcode = 'example_shortcode';

  /**
   * Function called when the behavior is registed by the component
   *
   * @override
   */
  public function register() {
    $this->addShortcode($this->Shortcode, array($this, 'registerShortcode'));
  }

  /**
   * Register the Shortcode
   */
  public function registerShortcode($atts) {
    return '<div js-react-module="example"></div>';
  }
}


?>
