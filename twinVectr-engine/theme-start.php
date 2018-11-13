<?php 
namespace twinVectr\engine;

require_once('twinVectr.themeStyles.php');
require_once('twinVectr.applyThemeGlobalHooks.php');

/**
 * 
 */

class Theme {

    public static $instance = null;
    public $theme_root_folder;
    public $developement;
    public $theme_root_url;
    public $option_prefix = 'twinVectr';
    public $component_root_folder = 'components';

    private $log_prefix =  'twinVectr';
    private $engine_root_folder = 'twinVectr-engine';
    private $abstract_root_folder = 'behaviours';
    private $libs_root_folder = 'libs';
    private $vc_templates = array();

    private $required_plugins = array();
    private $active_plugins = array();

    private $post_types = array();
    private $wordpress_helpers;
    private $loaded_compoments = array();



    private function __construct($development = false) {
        $this->development = $development;
        $this->theme_root_folder = get_template_directory();
        $this->theme_root_url = get_template_directory_uri();
        $this->loadAllLibs();
        $this->loadAllStyles();
        $this->loadThemeHelpers();
        $this->TokenizerService = new Tokenizer();
    }


    public function init() {
        $this->loadAllCompoments();
        $this->loadAllStyles();
    }


    public static function getInstance() {
        if(Theme::$instance) {
            return Theme::$instance;
        }
        $development = true; 
        return new Theme($development);
    }

    /**
     * Loads all Theme libraries
     */
    private function loadAllLibs(){
        // Get all libs files
        $themeLibs = glob($this->theme_root_folder . '/' . $this->engine_root_folder . '/' . $this->libs_root_folder . '/*/*.php', GLOB_NOSORT);
        foreach ($themeLibs as $req) {
          require_once($req);
        }
    }

    private function loadAllStyles() {
        $style_resolver = new ThemeStyle();
        $style_resolver->addAllStyles();
    }

    private function loadThemeHelpers() {
        GlobalHooks::applyThemeBasicHooks();
    }

    private function loadAllCompoments() {

        $abstractClasses = glob($this->theme_root_folder . '/' . $this->engine_root_folder . '/'. $this->abstract_root_folder . '/*.php');
        foreach ($abstractClasses as $req) {
            // Require each abstract class file
            require_once($req);
        }

        $componentCorefiles = glob($this->theme_root_folder . '/' . $this->engine_root_folder . '/' . $this->component_root_folder . '/*/*.php');
         
        foreach ($componentCorefiles as $file) {
            // Require the component file
            require_once($file);

            // Get component class
            $componentClass = $this->TokenizerService->getClassNameFromFile($file);

            // If component Class is found
            if($componentClass) {
            // Instantiate the component
            $compoment = new $componentClass(dirname($file));

            // If component has a proper class
            if ($compoment instanceof \Evoke\Components\Abstraction\Component) {
                // Create meta data object
                $metaData = array(
                'Name' => $compoment->Name,
                'Category' => $compoment->Category,
                'Instance' => $compoment,
                'File' => $file
                );

                // Track loaded components
                $this->loaded_compoments[] = $metaData;
            }
            // Invalid class
            else {
                //$this->logWarning('The class located in the file "' . $file . '" does not implement "\twinVector-engine\behaviours\Component" class - cannot be loaded as a component.');
            }
            }
        }
          
    }

}


function start() {
    Theme::$instance = Theme::getInstance();
    Theme::$instance->init();
}
