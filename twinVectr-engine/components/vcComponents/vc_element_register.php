<?php

class VisualComposerElementRegister extends twinVectr\engine\BehaviorAction
{

    public function __construct()
    {
        $this->register();
    }

    public function register()
    {
        $this->addAction(
            'vcv:api', array($this, 'registerElement')
        );
    }

    public function registerElement($api)
    {
        //twinVectr\engine\Theme::$instance->logError('Registering VC_Elements');
        $elementsToRegister = [
            'vcExampleComponent',
        ];
        /** @var \VisualComposer\Modules\Elements\ApiController $elementsApi */
        $elementsApi = $api->elements;
        foreach ($elementsToRegister as $tag) {
            $manifestPath = __DIR__ . '/elements/' . $tag . '/manifest.json';
            $elementBaseUrl = $tag;
            $elementsApi->add($manifestPath, $elementBaseUrl);
        }
    }

}
