<?php
namespace App\Http;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Db;
use App\Core\Response;

class AuthController extends Controller {
  /**
   * login
   */
  public function login() {
    $input = $this->app->getRequestData();
    $auth  = new Auth($this->app);

    if ($auth->validate($input)) {
      $db = Db::getInstance();
      $user = $db->table('users')
                  ->select('users.id, users.login, users.created_at')
                  ->where('login', $input['login'])
                  ->where('password', $auth->hash($input['password']))
                  ->first();

      if (!!$user) {
        $token      = $auth->createToken($user);
        $expired_at = (isset($input['remember_me']) && $input['remember_me'] === true) ? false : true;

        # Set session data
        $auth->setSession($token, $user['id'], $expired_at);

        return Response::json(['user' => $user, 'token' => $token]);
      }
    }
    return Response::json(['message' => 'Invalid creditionals', 'errors' => ['Invalid authorization data entered.']], 403);
  }

  /**
   * Logout
   */
  public function logout() {
    Auth::destroySession();
  }

  /**
   * Application version
   */
  public function version() {
    $version = (isset($this->app->config('app')['version']))
      ? $this->app->config('app')['version']
      :  '0.0.01';
    return Response::json(['version' => $version]);
  }
}
