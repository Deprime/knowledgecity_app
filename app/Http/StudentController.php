<?php
namespace App\Http;

use App\Core\Controller;
use App\Core\Db;
use App\Core\Response;
use App\Core\Auth;
use App\Core\Pagination;

class StudentController extends Controller {

  public function list() {
    $input = $this->app->getRequestData();
    $page = isset($input['page']) ? $input['page'] : 1;
    $page = ($page > 0) ? $page : 1;

    $row_count = 5;
    $offset    = $row_count * ($page - 1);

    $db = Db::getInstance();

    $total = (int) $db->table('students')->count();
    $student_list = $db->table('students')
                       ->join('sections', 'sections.id=students.section_id')
                       ->limit($row_count, $offset)
                       ->get();

    #TODO: wrap into some service

    $page_list = Pagination::generate($page, $row_count, $total);
    return Response::json([
      'student_list' => $student_list,
      'page_list'    => $page_list,
    ]);
  }


  /**
   * Store new student
   */
  public function store() {
    $input = $this->app->getRequestData();
    if (!!$input['student']) {
      $student = $input['student'];

      if (count($student) === 5) {
        $student['section_id'] = (int) $student['section_id'];

        $query  = "INSERT INTO `students` (`id`, `section_id`, `first_name`, `last_name`, `login`, `email`, `created_at`, `updated_at`) ";
        $query .= " VALUES (NULL, '".$student['section_id']."', '".$student['first_name']."', '".$student['last_name']."', '".$student['login']."', '".$student['email']."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $db = Db::getInstance();
        $db->raw($query);

        return Response::json(['student' => $student]);
      }
    }

    return Response::json(['message' => 'Invalid data', 'errors' => ['Invalid data.']], 403);
  }
}
