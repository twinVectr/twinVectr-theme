<?php

namespace twinVectr\engine;

/**
 * Base Action Behavior class
 */
class BehaviorFilter extends Behavior
{
    public function __construct($componentInstance)
    {
        // Base constructor
        parent::__construct($componentInstance);
    }

    /**
     * Add Wordpress filter hook
     * @param string $actionHookName Name of the hook action
     * @param string|array $callback Wordpress callback
     * @param int $priority Used to specify the order in which the functions associated with a particular action are executed
     * @param int $acceptedArgs The number of arguments the function accepts
     */
    protected function addFilter($filterHookName = '', $callback, $priority = 10, $acceptedArgs = 1)
    {
        // Basic Validation
        if (empty($filterHookName)) {
            Theme::$instance->logError('Component: ' . $this->_compoment->Name . ', Behavior: ' . $this->Name . ' (BehaviorAction) - filterhook is empty');
            return;
        }

        add_filter($filterHookName, $callback, $priority, $acceptedArgs);
    }
}
