<?php
namespace twinVectr\engine;

/**
 * Helper utilities for better logging in PHP/Wordpress
 */
class Logging
{
    /**
     * Converts an object into a string using the Wordpress Output Buffer
     * @param mixed $object Object which will be converted into string
     * @return string Returns converted object into string
     */
    public function ObjectToString($object)
    {
        ob_start();
        var_dump($object);
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }

    /**
     * Outputs a HTML log message
     * @param string $message Log message
     * @param string $color CSS Background color value, default 'lightblue'
     */
    public function HtmlLog($message, $color = 'lightblue')
    {
        echo '<pre style="background-color: ' . $color . '; padding: 15px; color: black; white-space: pre-wrap;"><p style="color: black; font-size: 10px; font-weight: bold;">twinVectr:</p>' . htmlspecialchars($message) . '</pre>';
    }
}
