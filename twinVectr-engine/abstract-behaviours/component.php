<?php

namespace twinVectr\engine;

class Component
{
    public $Name;
    public $Desc;
    public $required_components = array();
    private $component_folder;
    private $libs_root = 'libs';
    private $behaviors_root = 'behaviours';
    private $vc_templates_root = 'vc';
    private $loaded_views = array();
    private $loaded_behaviors = array();
    private $loaded_vc_templates = array();

    /**
     * Constructor
     *
     * @param string $componentFolder - Component folder passed by Evoke Theme
     */
    public function __construct($componentFolder)
    {
        $this->componentFolder = $componentFolder;
        if (!$this->Name || !$this->Desc) {
            $this->Name = 'Unknown Component';
            $this->Desc = 'Missing Description';
            twinVectr\engine\Theme::$instance->logError('Component: Virtual props "Name" and "Desc" must be set in derived class.');
        }
        // load all component behaviours
        $this->loadBehaviors();
    }

    /**
     * Load component's Behaviors
     */
    private function loadBehaviors()
    {
        // Get all behaviors
        $behaviors = glob($this->component_folder . '/' . $this->behaviors_root . '/*.php', GLOB_NOSORT);
        foreach ($behaviors as $file) {
            // Require the behavior file
            require_once $file;
            // Get behavior class
            $behaviorClass = \twinVectr\engine\Theme::$instance->TokenizerService->getClassNameFromFile($file);

            // If behavior Class is found
            if ($behaviorClass) {
                // Instantiate the behavior
                $behavior = new $behaviorClass($this);

                // If behavior has a proper class
                if ($behavior instanceof twinVectr\engine\Behavior) {
                    // Register behavior
                    $behavior->register();

                    // Create metaData object
                    $metaData = array(
                        'Name' => $behavior->Name,
                        'Instance' => $behavior,
                        'File' => $file,
                    );
                    // Track loaded behaviors
                    $this->_loadedBehaviors[] = $metaData;
                }
                // Invalid class
                else {
                    twinVectr\engine\Theme::$instance->logWarning('The class located in the file "' . $file . '" does not implement "twinVectr\engine\Behavior" class - cannot be loaded as an action.');
                }
            }
        }
    }

}
