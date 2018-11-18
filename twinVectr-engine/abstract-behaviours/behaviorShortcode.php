<?php

namespace twinVectr\engine;

class BehaviorShortcode extends Behavior
{

    public function __construct($componentInstance)
    {
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
        if (!$shortcodeName) {
            Theme::$instance->logError('Component: ' . $this->_compoment->Name . ', Behavior: ' . $this->Name . ' (BehaviorShortcode) - "shortcodeName" is empty');
            return;
        }
        add_shortcode($shortcodeName, $callback);
    }

}
