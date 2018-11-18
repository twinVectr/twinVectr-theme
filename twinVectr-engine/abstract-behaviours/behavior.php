<?php

namespace twinVectr\engine;

/**
 * Base Behavior class
 */
class Behavior
{
    // Behavior Basic Props
    public $Name;
    public $Desc;

    // Component instance
    protected $compoment;

    public function __construct($componentInstance)
    {
        // Updated component instance
        $this->_compoment = $componentInstance;

        // Basic Validation
        if (!$this->Name || !$this->Desc) {
            // Defaults
            $this->Name = 'Unknown Action';
            $this->Desc = 'Missing Description';
            Theme::$Instance->logError('Component: ' . $componentInstance->Name . ', Behavior:Unknown - Virtual props "Name" and "Desc" must be set in derived class.');
        }
    }

    /**
     * Returns component instance
     */
    public function getComponent()
    {
        return $this->_compoment;
    }

    /**
     * Add JS Localization
     *
     * @param array $resources Array of localization string ('key' => 'value')
     */
    protected function addJsLocalization($resources)
    {
        $this->_compoment->addJsLocalization($resources);
    }

}
