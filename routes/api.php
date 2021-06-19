<?php

use App\Http\StudentController;
use App\Http\AuthController;

return [
  ['name' => '/users', 'method' => 'get',     'class' => StudentController::class, 'action' => 'list',  'auth' => true],
  ['name' => '/auth',  'method'  => 'post',   'class' => AuthController::class, 'action' => 'login',    'auth' => false],
  ['name' => '/auth',  'method'  => 'delete', 'class' => AuthController::class, 'action' => 'logout',   'auth' => false],
  ['name' => '/version', 'method' => 'get',   'class' => AuthController::class, 'action' => 'version',  'auth' => false],
];
