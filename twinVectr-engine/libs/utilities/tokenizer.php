<?php


namespace twinVectr\engine;

/**
 * PHP Tokenizer Utilities
 */
class Tokenizer {
  /**
   * Get name of the first class located in the file
   * 
   * It includes the namespace
   * It is not reading the whole file, it reads 512 bytes in an iteration
   * Reference: http://php.net/manual/en/function.token-get-all.php
   * Reference: http://stackoverflow.com/questions/7153000/get-class-name-from-file
   *
   * @param string $filepath Path to the file
   * @return string Name of the class located in the file (including namespace if present)
   */
  public function getClassNameFromFile($filepath) {
    $class = $namespace = '';

    try {
      $fp = fopen($filepath, 'r');
      $buffer = '';

      // Token counter
      $i = 0;

      // While the class is not found
      while (!$class) {
        // If we reach end of the file, break the looping
        if (feof($fp)) {
          break;
        }

        // Read 1024 bytes of file
        $buffer .= fread($fp, 1024);

        // Get all tokens in the buffer
        $tokens = token_get_all($buffer);

        // If there is not open curly bracket in the buffer
        // Skip this iteration. Class needs to start with "{"
        if (strpos($buffer, '{') === false) {
          continue;
        }

        // Loop trough all tokens
        for (;$i < count($tokens); $i++) {
          // Namespace token
          if ($tokens[$i][0] === T_NAMESPACE) {
              // Loop trough following tokes to find namespace value
              for ($j = $i + 1; $j < count($tokens); $j++) {
                // Namespace parts
                if ($tokens[$j][0] === T_STRING) {
                  // Construct the namespace value
                  $namespace .= '\\'. $tokens[$j][1];
                }
                // End of the namespace definition: "foo\bar {" or "foo\bar;"
                // Break this loop and continue to finding the classname
                else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                  break;
                }
              }
          }

          // Class token
          if ($tokens[$i][0] === T_CLASS) {
              // Loop trough following tokes to find class value
              for ($j = $i + 1; $j < count($tokens); $j++) {
                // Beginning of class found
                if ($tokens[$j] === '{') {
                  // Set the class value
                  $class = $tokens[$i + 2][1];
                }
              }
          }
        }
      }
    }
    catch (Exception $e) {}

    // Return the namespace and class
    if($namespace) {
      return $namespace . '\\' . $class;
    }

    return $class;
  }
}

?>
