<?php

namespace App\Core;

/**
 * Simple auth
 */
class Auth {

  /**
   * Application instance
   *
   * @var object
   */
  protected $app;
  protected $prefix_salt;
  protected $sufix_salt;
  const SESSION_DURATION = 15;

  public function __construct($app) {
    $this->app = $app;

    $this->prefix_salt = (isset($this->app->config('auth')['prefix_salt']))
      ? $this->app->config('auth')['prefix_salt']
      : 's7fh23D6s';

    $this->sufix_salt = (isset($this->app->config('auth')['sufix_salt']))
      ? $this->app->config('auth')['sufix_salt']
      : 'v7@s9Kc';

    $this->encryption_key = (isset($this->app->config('auth')['encryption_key']))
      ? $this->app->config('auth')['encryption_key']
      : 'ab86d144e3f080b61c7c2e43';
  }


  /**
   * Make hash
   *
   * @param string $string
   * @return string
   */
  public function hash($string) {
    $hash = md5($this->prefix_salt  . $string . $this->sufix_salt);
    return $hash;
  }

  /**
   * Set expired
   *
   * @param string $token
   * @param int $id
   * @return void
   */
  public static function refreshExpiredAt() {
   $_SESSION['expired_at'] = date("Y-m-d H:i:s", strtotime("+" .self::SESSION_DURATION. " minutes"));
   return $_SESSION['expired_at'];
  }


  /**
   * Set session data
   *
   * @param string $token
   * @param int $id
   * @param int $expired_at
   * @return void
   */
  public function setSession(string $token, int $id, bool $expired_at = true) {
    $_SESSION['token'] = $token;
    $_SESSION['id'] = $id;
    if ($expired_at)
      $this->refreshExpiredAt();
  }

  /**
   * Check session
   *
   * @return boolean
   */
  public static function checkSession() {
    if (!!$_SESSION['token'] && !!$_SESSION['id']) {
      if (isset($_SESSION['expired_at'])) {
        $now = date("Y-m-d H:i:s");
        if (strtotime($_SESSION['expired_at']) > strtotime($now))
          self::refreshExpiredAt();
        else
          return false;
      }
      return true;
    }
    return false;
  }

  /**
   * Destroy session
   *
   * @return void
   */
  public static function destroySession() {
    unset($_SESSION['token']);
    unset($_SESSION['id']);
    unset($_SESSION['expired_at']);
  }


  /**
   * Minimalistic auth data validation
   *
   * @param array $input
   * @return boolean
   */
  public function validate(array $input) {
    return (
      isset($input['login']) && isset($input['password'])
      && strlen($input['login']) >= 4 && strlen($input['password']) >= 4
    );
  }


  /**
   * Some tokenization
   *
   * @param array $input
   * @return boolean
   */
  public function createToken(array $input) {
    # Prepare string
    $string = $input['id'].'.'.$input['login'];
    $token  = $this->hash($string);
    return $token;
  }
}
