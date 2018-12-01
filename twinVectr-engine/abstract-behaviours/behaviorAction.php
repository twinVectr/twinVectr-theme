<?php

namespace twinVectr\engine;

/**
 * Base Action Behavior class
 */
class BehaviorAction extends Behavior
{
    public function __construct($componentInstance = '')
    {
        // Base constructor
        parent::__construct($componentInstance);
    }

    /**
     * Add Wordpress action hook
     * Validate action hook name first
     * @param string $actionHookName Name of the hook action
     * @param string|array $callback Wordpress callback
     * @param int $priority Used to specify the order in which the functions associated with a particular action are executed
     * @param int $acceptedArgs The number of arguments the function accepts
     */
    protected function addAction($actionHookName = '', $callback, $priority = 10, $acceptedArgs = 1)
    {
        // Basic Validation
        if (empty($actionHookName)) {
            Theme::$instance->logError('Component: ' . $this->_compoment->Name . ', Behavior: ' . $this->Name . ' (BehaviorAction) - "actionHookName" is empty');
            return;
        }

        add_action($actionHookName, $callback, $priority, $acceptedArgs);
    }
}
