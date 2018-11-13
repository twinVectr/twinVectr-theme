<?php

class BehaviorActionRegistration extends \twinVectr\engine\BehaviorAction {

  public $Name = 'Action Registration';
  public $Desc = 'Action Registrations for the component';


  /**
   * Function called when the behavior is registed by the component
   *
   * @override
   */
  public function register() {
    $this->addAction('vc_before_init', array($this, 'registerAction') );
  }

  /**
   * Register the Action
   */
  public function registerAction() {
    vc_map(array(
      'name' => __( 'Example_vc_component', \Evoke\Core\Theme::$Instance->TextDomain ),
      'base' => 'Example_action',
      'category' => __( 'Modules', \Evoke\Core\Theme::$Instance->TextDomain ),
      'description' => __( 'Example VC Template', \Evoke\Core\Theme::$Instance->TextDomain ),
      'params' => array(
        array(
          'type'        => 'textfield',
          'holder'      => 'div',
          'class'       => '',
          'heading'     => __( 'Inner Content', \Evoke\Core\Theme::$Instance->TextDomain ),
          'param_name'  => 'innercontent',
          'value'       => __( '', \Evoke\Core\Theme::$Instance->TextDomain ),
          'description' => __( 'What is ze content?', \Evoke\Core\Theme::$Instance->TextDomain )
        )
      )
    ));
  }
}


?>
