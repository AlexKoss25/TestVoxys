<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'users';
    $link = mysqli_connect($host, $user, $pass, $database);
    mysqli_set_charset($link, "utf8mb4");
    
  
  if (!$link) {
    echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
  }  
?>