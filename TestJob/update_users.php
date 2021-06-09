<?php
    require_once 'link.php';
    mysqli_select_db($link, 'users') or die('Could not select database');

    $tableName = $_POST['table'];
    $fieldName = $_POST['field'];
    $value = $_POST['value'];
    $id = $_POST['id'];

    $query = "UPDATE `$tableName` SET `$fieldName` = '$value' WHERE `$tableName`. `id` = $id";
    $result = mysqli_query($link, $query);
    if (mysqli_errno($link) > 0){
        echo mysqli_error($link);
    }    
  
?>

