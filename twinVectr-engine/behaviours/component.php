<?php

namespace twinVectr\engine\behaviours;

class Component {

    public $Name;
    public $Desc;
    public $required_components = array();
    private $component_folder;
    private $libs_root = 'libs';
    private $behaviors_root = 'behaviors';
    private $vc_templates_root = 'vc';
    private $loaded_views = array();
    private $loaded_behaviors = array();
    private $loaded_vc_templates = array();

    /**
     * Constructor
     *
     * @param string $componentFolder - Component folder passed by Evoke Theme
     */
    function __construct($componentFolder) {
        // Updated comportment folder
        $this->componentFolder = $componentFolder;

        // Basic Validation
        if(!$this->Name || !$this->Desc) {
        // Defaults
        $this->Name = 'Unknown Component';
        $this->Desc = 'Missing Description';

        // Log
        //\Evoke\Core\Theme::$Instance->logError('Component: Virtual props "Name" and "Desc" must be set in derived class.');
        }

        // Load component libs
        $this->loadLibs();

        // Load component behaviors
        $this->loadBehaviors();
    }



    /**
     * Load component's libs
     */
    private function loadLibs(){
        // Get all libs
        // $libs = glob($this->_componentFolder . '/' . $this->_libsRoot . '/*.php', GLOB_NOSORT);
        // foreach ($libs as $file) {
        // // Require the component file
        // require_once($file);
        // }
    }

    /**
     * Load component's Behaviors
     */
    private function loadBehaviors(){
        // Get all behaviors
        $behaviors = glob($this->component_folder . '/' . $this->behaviors_root . '/*.php', GLOB_NOSORT);
        foreach ($behaviors as $file) {
        // Require the behavior file
        require_once($file);

        // Get behavior class
        $behaviorClass = \twinVectr\engine\Theme::$Instance->TokenizerService->getClassNameFromFile($file);

        // If behavior Class is found
        if($behaviorClass) {
            // Instantiate the behavior
            $behavior = new $behaviorClass($this);

            // If behavior has a proper class
            if ($behavior instanceof \twinVectr\engine\Behavior) {
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
            //\Evoke\Core\Theme::$Instance->logWarning('The class located in the file "' . $file . '" does not implement "\Evoke\Components\Abstraction\Behavior" class - cannot be loaded as an action.');
            }
        }
        }
    }

}


?>
