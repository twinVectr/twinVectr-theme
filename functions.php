<?php
/**
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package twinVectr-theme
 */

use twinVectr\engine;
define("ENGINE_DIR", "twinVectr-engine");


// Require the Theme core file
require_once(get_template_directory() . '/'. ENGINE_DIR .'/theme-start.php');

// Call the Start method which instantiates the twin-vectr engine (theme)
add_action('after_setup_theme', 'twinVectr\engine\start');








