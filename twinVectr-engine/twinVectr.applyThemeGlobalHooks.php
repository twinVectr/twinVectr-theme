<?php

namespace twinVectr\engine;

class GlobalHooks {

    public static function applyThemeBasicHooks() {
      GlobalHooks::resolveGlobalWordpressActions();
      GlobalHooks::resolveGlobalWordpressFilters();
    }
    /**
     * Resolve Global Wordpress filters required sooner than components are loaded
     */
    private static function resolveGlobalWordpressFilters() {
      // Options framework options file location override
      //add_filter('options_framework_location', array($this, 'updateOptionsFrameworkLocationFile'));
    }

    /**
     * Resolve Global Wordpress actions
     */
    private static function resolveGlobalWordpressActions() {
      // AFC Registration
      // add_action('acf/init', array(\Evoke\Core\Theme::$Instance, 'registerAllLocalGroups'));

      // // Post Type Registration
      // add_action('init', array(\Evoke\Core\Theme::$Instance, 'registerAllPostTypes'));
    }

}
