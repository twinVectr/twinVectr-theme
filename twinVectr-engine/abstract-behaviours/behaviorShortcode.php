<?php

namespace twinVectr\engine;

class BehaviorShortcode extends Behavior
{
    // Shortcode key
    public $Shortcode;
    public function __construct($componentInstance)
    {
        // Basic Validation
        if (!$this->Shortcode) {
            twinVectr\engine\Theme::$instance->logError('Component: ' . $componentInstance->Name . ', Behavior: ' . $this->Name . ' (BehaviorShortcode) - "Shortcode" prop must be set.');
        }
        // Base constructor
        parent::__construct($componentInstance);
    }

    /**
     * Add Wordpress shortcode
     * Validate shortcode name first
     * @param string $shortcodeName Name of the shortcode
     * @param string|array $callback Wordpress render callback
     */
    protected function addShortcode($shortcodeName, $callback)
    {
        // Basic Validation
        if ($this->Shortcode != $shortcodeName) {
            twinVectr\engine\Theme::$instance->logError('Component: ' . $this->_compoment->Name . ', Behavior: ' . $this->Name . ' (BehaviorShortcode) - "shortcodeName" parameter passed into the addFilter() method must be equal to Behavior\'s "Shortcode" prop.');
            return;
        }
        add_shortcode($shortcodeName, $callback);
    }

}
