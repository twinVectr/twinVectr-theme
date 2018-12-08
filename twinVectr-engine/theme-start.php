<?php
namespace twinVectr\engine;

require_once 'twinVectr.themeStyles.php';
require_once 'twinVectr.applyThemeGlobalHooks.php';
require_once 'twinVectr.addThemeSupport.php';

/**
 * twinVectr Engine
 * Class Theme initilizes the theme components and behaviours
 */

class Theme
{
    public static $instance = null;
    public $theme_root_folder;
    public $developement;
    public $theme_root_url;
    public $option_prefix = 'twinVectr';
    public $component_root_folder = 'components';
    public $vc_component_root_folder = 'vcComponents';
    public $wordpress_components = 'wordpress_components';

    private $log_prefix = 'twinVectr';
    private $engine_root_folder = 'twinVectr-engine';
    private $abstract_root_folder = 'abstract-behaviours';
    private $libs_root_folder = 'libs';
    private $vc_templates = array();

    private $required_plugins = array();
    private $active_plugins = array();

    public $logging_service;
    public $tokenizer_service;

    private $post_types = array();
    private $wordpress_helpers;
    private $loaded_compoments = array();

    private function __construct($development = true)
    {
        $this->development = $development;
        $this->theme_root_folder = get_template_directory();
        $this->theme_root_url = get_template_directory_uri();
        $this->loadAllLibs();
        $this->loadAllStyles();
        $this->loadThemeHelpers();
        $this->loadThemeSupport();
        $this->tokenizer_service = new Tokenizer();
        $this->logging_service = new Logging();
    }

    public function init()
    {
        $this->loadAllCompoments();
        $this->loadAllStyles();
    }

    /**
     * initilizes a singleton object for the theme engine
     */
    public static function getInstance()
    {
        if (Theme::$instance) {
            return Theme::$instance;
        }
        $development = true;
        return new Theme($development);
    }

    /**
     * Loads all Theme libraries
     */
    private function loadAllLibs()
    {
        // Get all libs files
        $themeLibs = glob($this->theme_root_folder . '/' . $this->engine_root_folder . '/' . $this->libs_root_folder . '/*/*.php', GLOB_NOSORT);
        foreach ($themeLibs as $req) {
            require_once $req;
        }
    }

    /**
     * Loads all the component styles
     */
    private function loadAllStyles()
    {
        $style_resolver = new ThemeStyle();
        $style_resolver->addAllStyles();
    }

    /**
     * Theme wordpress helpers
     */
    private function loadThemeHelpers()
    {
        GlobalHooks::applyThemeBasicHooks();
    }

    /**
     * Load all wordpress theme support
     */
    private function loadThemeSupport()
    {
        ThemeSupport::addThemeSupport();
    }

    /**
     * Global Error Log
     *
     * In Development mode it is being log as an HTML message
     * In Production it is logged into PHP error_log
     *
     * @param string error - Error Message
     */
    public function logError($error)
    {
        if ($this->development) {
            $this->logging_service->HtmlLog($error, 'lightcoral');
        } else {
            error_log($this->log_prefix . $error);
        }
    }

    /**
     * Global Warring Log
     *
     * In Development mode it is being log as an HTML message
     * In Production it is logged into PHP error_log
     *
     * @param string warring - Warring Message
     */
    public function logWarning($warning)
    {
        if ($this->development) {
            $this->logging_service->HtmlLog($warning, 'antiquewhite');
        } else {
            error_log($this->log_prefix . $warning);
        }
    }

    /**
     * Loads all the component main info to load their behaviours
     */
    private function loadAllCompoments()
    {

        // requires all the abstract behaviour for the componet classes
        $abstractClasses = glob($this->theme_root_folder . '/' . $this->engine_root_folder . '/' . $this->abstract_root_folder . '/*.php');
        foreach ($abstractClasses as $req) {
            require_once $req;
        }

        //Load visual composer registeration file
        $visualComposerComponents = glob($this->theme_root_folder . '/' . $this->engine_root_folder . '/' . $this->component_root_folder . '/' . $this->vc_component_root_folder . '/*.php');
        foreach ($visualComposerComponents as $file) {
            require_once $file;
            $vc_registration = $this->tokenizer_service->getClassNameFromFile($file);
            if ($vc_registration) {
                // Instantiate the
                new $vc_registration(dirname($file));

            }
        }
        // Loads all the component base info
        $wordpressComponents = glob($this->theme_root_folder . '/' . $this->engine_root_folder . '/' . $this->component_root_folder . '/' . $this->wordpress_components . '/*/*.php');
        foreach ($wordpressComponents as $file) {
            require_once $file;
            // Get component class
            $componentClass = $this->tokenizer_service->getClassNameFromFile($file);
            // If component Class is found
            if ($componentClass) {
                // Instantiate the component
                $component = new $componentClass(dirname($file));

                // If component has a proper class
                if (is_subclass_of($component, 'twinVectr\engine\Component')) {
                    // Create meta data object
                    $metaData = array(
                        'Name' => $component->Name,
                        'Instance' => $component,
                        'File' => $file,
                    );
                    // Track loaded components
                    $this->loaded_compoments[] = $metaData;
                }
                // Invalid class
                else {
                    $this->logWarning('The class located in the file "' . $file . '" does not implement "twinVectr\engine\component" class - cannot be loaded as a component.');
                }
            }
        }
    }
}

/**
 * start() initiates the twinVectr engine
 * initializes Theme class - singleton
 */
function start()
{
    Theme::$instance = Theme::getInstance();
    Theme::$instance->init();
}
