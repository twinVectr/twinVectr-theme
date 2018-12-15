<?php
namespace vcExampleComponent;

use VisualComposer\Framework\Container;
use VisualComposer\Framework\Illuminate\Support\Module;
use VisualComposer\Helpers\Traits\EventsFilters;
use VisualComposer\Helpers\Traits\WpFiltersActions;

class VCExampleShortcode extends Container implements Module
{
    use EventsFilters;
    use WpFiltersActions;

    public function __construct()
    {
        if (!defined('VC_EXAMPLE_SHORTCODE')) {
            $this->addFilter('vcv:editor:variables vcv:editor:variables/vcExampleComponent', 'getVariables');
            define('VC_EXAMPLE_SHORTCODE', true);
        }
    }

    protected function getVariables($variables)
    {
        $value = $this->getPostLogo();
        $variables[] = [
            'key' => 'vcvLogo',
            'value' => $value,
            'type' => 'variable',
        ];

        return $variables;
    }

    private function getPostLogo()
    {
        return 'test';
    }

}
