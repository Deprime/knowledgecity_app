<?php

namespace App;

use App\Core\Router;
use App\Core\Db;
use App\Core\Auth;
use App\Core\Response;


class Application {

  /**
   * The base path of the application installation.
   *
   * @var string
   */
  protected $base_path;


  /**
   * The config path of the application installation.
   *
   * @var string
   */
  protected $config_path;


  /**
   * Loaded configs
   *
   * @var array
   */
  protected $loadedConfigs = [];

  /**
   * API Routes
   *
   * @var array
   */
  protected $routes = [];

  /**
   * Request headers
   *
   * @var array
   */
  protected $headers = [];


  /**
   * Request info
   *
   * @var array
   */
  protected $request = [];


  public function __construct($base_path = null) {
    $this->base_path = $base_path;
    $this->bootstrapConfig();
    $this->bootstrapRoutes();
    $this->getHeaders();
    $this->getRequest();
  }



  public function getHeaders() {
    return $this->headers = apache_request_headers();
  }


  public function getRequestData() {
    if ($this->request['REQUEST_METHOD'] === "GET") {
      return $_GET;
    }
    if ($this->request['REQUEST_METHOD'] === "POST") {
      return json_decode(file_get_contents('php://input'), true);
    }
    if ($this->request['REQUEST_METHOD'] === "PUT") {
      return $_POST;
    }
  }

  public function getRequest() {
    return $this->request = $_SERVER;
  }


  /**
   * Get the config path for the application.
   *
   * @param  string|null  $path
   * @return string
   */
  public function configPath()
  {
    return $this->base_path . DIRECTORY_SEPARATOR . 'config';
  }


  /**
   * Get the routes path for the application.
   *
   * @param  string|null  $path
   * @return string
   */
  public function routesPath()
  {
    return $this->base_path . DIRECTORY_SEPARATOR . 'routes';
  }

  /**
   * Bootstrap all config files
   *
   * @return void
   */
  protected function bootstrapConfig() {
    $config_list = scandir($this->configPath());

    if (count($config_list) > 2) {
      $config_list = array_slice($config_list, 2);

      foreach ($config_list as $config_file) {
        $file_info = pathinfo($this->configPath() . DIRECTORY_SEPARATOR . $config_file);

        if ($file_info['extension'] === 'php') {
          $config = require_once $this->configPath() . DIRECTORY_SEPARATOR . $config_file;
          if (is_array($config))
            $this->loadedConfigs[$file_info['filename']] = $config;
        }
      }
    }
  }

  /**
   * Bootstrap routes
   *
   * @return void
   */
  protected function bootstrapRoutes() {
    $routes = require_once $this->routesPath() . DIRECTORY_SEPARATOR . 'api.php';
    if (is_array($routes)) {
      $this->routes = $routes;
    }
  }


  /**
   * Get config
   *
   * @param string $config_name
   * @return array|boolean
   */
  public function config($config_name) {
    return (isset($this->loadedConfigs[$config_name])) ? $this->loadedConfigs[$config_name] : false;
  }

  /**
   * Default app settings
   * TODO: default lang
   * TODO: reading env
   *
   * @return void
   */
  private function tweek()
  {
    $timezone = (isset($this->config('app')['timezone']))
      ? $this->config('app')['timezone']
      : 'Europe/Moscow';

    # Set default timezone
    date_default_timezone_set($timezone);
    session_start();
  }


  /**
   * Ignite application routing.
   *
   * @return void
   */
  private function routing()
  {
    foreach ($this->routes as $route) {
      Router::add($route['name'], function() use ($route) {
        $action     = $route['action'];
        $class_name = $route['class'];
        $instance = new $class_name($this);

        if (is_callable([$instance, $action]))
          $instance->$action();
        else
          return Response::methodNotAllowed();
      }, $route['method'], $route['auth']);
    }

    Router::pathNotFound(function() {
      header("Location: ". $this->request['REQUEST_SCHEME'] . "://" . $this->request['HTTP_HOST'] . "/index.html");
    });

    Router::unauthorized(function() {
      Auth::destroySession();
      return Response::unauthorized();
    });

    Router::run('/');
  }



  /**
   * Run application
   */
  public function run() {
    # Tweek default app setings
    $this->tweek();

    # Set conection config for DB instance
    $db = Db::getInstance();
    $db->connection($this->config('database'));

    # Ignite application routing
    $this->routing();
  }
}
