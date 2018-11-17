<?php

class BehaviorActionRegistration extends \twinVectr\engine\BehaviorAction
{
    public $Name = 'Action Registration';
    public $Desc = 'Action Registrations for the component';

    /**
     * Function called when the behavior is registed by the component
     */
    public function register()
    {
        $this->addAction('vc_before_init', array($this, 'registerAction'));
    }

    /**
     * Register the Action
     */
    public function registerAction()
    {
        vc_map(array(
            'name' => 'Example_vc_component',
            'base' => 'Example_action',
            'category' => 'Modules',
            'description' => 'Example VC Template',
            'params' => array(
                array(
                    'type' => 'textfield',
                    'holder' => 'div',
                    'class' => '',
                    'heading' => 'Inner Content',
                    'param_name' => 'innercontent',
                    'value' => '',
                    'description' => 'What is ze content?',
                ),
            ),
        ));
    }
}
