<?php

namespace App\Core;

/**
 * Base controller
 */
class Controller {

  /**
   * Application instance
   *
   * @var object
   */
  protected $app;

  public function __construct($app) {
    $this->app = $app;
  }
}
