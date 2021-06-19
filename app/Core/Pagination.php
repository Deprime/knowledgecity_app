<?php

namespace App\Core;

/**
 * Simple auth
 */
class Pagination {

  /**
   * generate pagination array
   * @param
   * @return array
   */
  public static function generate($page, $row_count, $total) {
    $paginate = [
      'current_page' => $page,
      'total' => $total,
      'pages' => ceil($total / $row_count),
      'prev'  => ($page > 1) ? $page - 1 : false,
      'next'  => ($page < ceil($total / $row_count)) ? $page + 1 : false,
    ];

    $page_list = [];
    $page_list[] = ['number' => $paginate['prev'], 'title' => '« Prev', 'current' => false];

    for ($i=1; $i <= $paginate['pages']; $i++) {
      $page_list[] = [
        'number' => $i,
        'title'  => $i,
        'current' => ($page == $i) ? 'current-page' : false,
      ];
    }

    $page_list[] = [
      'number' => $paginate['next'],
      'title' => 'Next »',
      'current' => false
    ];

    return $page_list;
  }
}
