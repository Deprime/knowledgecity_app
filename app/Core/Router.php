<?php

namespace App\Core;

/**
 * Simple router class
 */
class Router {
  private static $routes             = [];
  private static $path_not_found     = null;
  private static $method_not_allowed = null;
  private static $unauthorized       = null;

  /**
    * Function used to add a new route
    * @param string $expression    Route string or expression
    * @param callable $function    Function to call if route with allowed method is found
    * @param string|array $method  Either a string of allowed method or an array with string values
    */
  public static function add($expression, $function, $method = 'get', $auth = false) {
    self::$routes[] = [
      'expression' => $expression,
      'function'   => $function,
      'method'     => $method,
      'auth'       => $auth,
    ];
  }


  /**
   * Method description
   *
   * @return
   */
  public static function getAll(){
    return self::$routes;
  }


  /**
   * Method description
   *
   * @return
   */
  public static function pathNotFound($function) {
    self::$path_not_found = $function;
  }



  /**
   * Method description
   *
   * @return
   */
  public static function methodNotAllowed($function) {
    self::$method_not_allowed = $function;
  }


  /**
   * Method description
   *
   * @return
   */
  public static function unauthorized($function) {
    self::$unauthorized = $function;
  }


  /**
   * Method description
   *
   * @return
   */
  public static function run($basepath = '', $case_matters = false, $trailing_slash_matters = false, $multimatch = false) {
    $basepath   = rtrim($basepath, '/');
    $parsed_url = parse_url($_SERVER['REQUEST_URI']);
    $path       = '/';

    // If there is a path available
    if (isset($parsed_url['path'])) {
  	  if ($trailing_slash_matters) {
  		  $path = $parsed_url['path'];
  	  }
      else {
        $path = ($basepath.'/'!=$parsed_url['path']) ? rtrim($parsed_url['path'], '/') : $parsed_url['path'];
  	  }
    }

  	$path   = urldecode($path);
    $method = $_SERVER['REQUEST_METHOD'];
    $path_match_found  = false;
    $route_match_found = false;

    foreach (self::$routes as $route) {
      // Add basepath to matching string
      if ($basepath != '' && $basepath != '/') {
        $route['expression'] = '('.$basepath.')'.$route['expression'];
      }

      // Add 'find string start' automatically
      $route['expression'] = '^'.$route['expression'];

      // Add 'find string end' automatically
      $route['expression'] = $route['expression'].'$';

      // Check path match
      if (preg_match('#'.$route['expression'].'#'.($case_matters ? '' : 'i').'u', $path, $matches)) {
        $path_match_found = true;

        // Cast allowed method to array if it's not one already, then run through all methods
        foreach ((array)$route['method'] as $allowedMethod) {
          if (strtolower($method) == strtolower($allowedMethod)) {
            #TODO: middleware binding
            if ($route['auth']) {
              if (!\App\Core\Auth::checkSession()) {
                call_user_func_array(self::$unauthorized, Array($path, $method));
                break;
              }
            }

            array_shift($matches); // Always remove first element. This contains the whole string

            if ($basepath != '' && $basepath != '/')
              array_shift($matches); // Remove basepath

            if ($return_value = call_user_func_array($route['function'], $matches))
              echo $return_value;

            $route_match_found = true;
            break;
          }
        }
      }

      // Break the loop if the first found route is a match
      if ($route_match_found && !$multimatch)
        break;
    }

    // No matching route was found
    if (!$route_match_found) {
      if ($path_match_found) {
        if (self::$method_not_allowed)
          call_user_func_array(self::$method_not_allowed, Array($path, $method));
      } else {
        if (self::$path_not_found)
          call_user_func_array(self::$path_not_found, Array($path));
      }
    }
  }
}
