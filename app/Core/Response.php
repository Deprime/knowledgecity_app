<?php

namespace App\Core;

/**
 * Simple response
 */
class Response {


  /**
   * Method description
   *
   * @param array $data
   * @param integer $code
   * @return void
   */
  public static function json($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data);
  }


  /**
   * Bad request
   *
   * @param integer $code
   * @return void
   */
  public static function badRequest($code = 400) {
    http_response_code($code);
    echo json_encode($code.': Bad Request');
  }

  /**
   * Method not allowed
   *
   * @param integer $code
   * @return void
   */
  public static function methodNotAllowed($code = 405) {
    http_response_code($code);
    echo json_encode($code.': Method Not Allowed');
  }

  /**
   * Unauthorized
   *
   * @param integer $code
   * @return void
   */
  public static function unauthorized($code = 401) {
    http_response_code($code);
    echo json_encode($code.': Unauthorized');
  }
}
