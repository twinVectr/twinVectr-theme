<?php

namespace twinVectr\engine;

class ThemeStyle
{

    public function __construct()
    {
        $root_directory = get_template_directory();
        $root_url = get_template_directory_uri();
    }

    public function addAllStyles()
    {
        add_action('wp_enqueue_scripts', array($this, 'resolvePublicStylesScripts'), 999);
        add_action('admin_enqueue_scripts', array($this, 'resolveAdminStylesScripts'), 999);
    }

    public function resolvePublicStylesScripts()
    {
        $this->resolvePublicStyles();
        $this->resolvePublicScripts();
    }

    public function resolveAdminStylesScripts()
    {
        //TODO add admin styles
    }

    /**
     * Resolves the basic public styles
     */
    protected function resolvePublicStyles()
    {
        // Register main admin stylesheet - Development or Production
        if (Theme::$instance->development) {
            //wp_register_style('css-main', get_stylesheet_directory_uri() . '/dist/css/main.css', array(), '1.0.0', 'all');
        } else {
            // wp_register_style('css-main', get_stylesheet_directory_uri() . '/dist/css/main.min.css', array(), '1.0.0', 'all');
        }

        // Enqueue Styles
        // wp_enqueue_style('css-main');
    }

    /**
     * Resolves the basic public scripts
     */
    protected function resolvePublicScripts()
    {

        $bundle_files = glob(Theme::$instance->theme_root_folder . "/dist/js-chunks/entries/desktop/*.js");
        foreach ($bundle_files as $key => $js_file) {
            preg_match('/\/dist\/js-chunks\/entries\/desktop\/[\w.]+/', $js_file, $matches);
            $handler = "reactApp-bundle" . $key;
            // wp_enqueue_script($handler, Theme::$instance->theme_root_url . $matches[0], '', '', true);
        }

    }

}
