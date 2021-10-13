<?php
namespace App\Http;

use App\Core\Controller;
use App\Core\Db;
use App\Core\Response;

class SectionController extends Controller {

  public function list() {
    $input = $this->app->getRequestData();
    $db    = Db::getInstance();

    $section_list = $db->table('sections')->get();

    return Response::json([
      'section_list' => $section_list,
    ]);
  }
}
