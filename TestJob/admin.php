<?php

ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ERROR);


require_once 'link.php';



if (!empty($_POST['last_name'] or $_POST['first_name'] or $_POST['patronymic'])) {

    $input_last_name = $_POST['last_name'];
    $input_first_name  = $_POST['first_name'];
    $input_patronymic  = $_POST['patronymic'];
    $input_status  = 'Первый';


    $sql = mysqli_query($link, "INSERT INTO `users` (`id`, `last_name`, `first_name`, `patronymic`, `status` ) VALUES (NULL, '$input_last_name', '$input_first_name', '$input_patronymic', '$input_status')");

    if ($sql) {
        echo '<p>Данные успешно добавлены в таблицу.</p>';
    } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
}

$query = 'SELECT * FROM users';
$result_users = mysqli_query($link, $query) or die('Query failed: ' . mysqli_error($link));

?>

<!DOCTYPE html>
<html>

<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <meta charset="UTF-8">
    <title>Админ</title>
</head>
<style>
    .table_sort table {
        border-collapse: collapse;
    }

    .table_sort th {
        color: #ffebcd;
        background: #008b8b;
        cursor: pointer;
    }

    .table_sort td,
    .table_sort th {
        width: 150px;
        height: 40px;
        text-align: center;
        border: 2px solid #846868;
    }

    .table_sort tbody tr:nth-child(even) {
        background: #e3e3e3;
    }

    th.sorted[data-order="1"],
    th.sorted[data-order="-1"] {
        position: relative;
    }

    th.sorted[data-order="1"]::after,
    th.sorted[data-order="-1"]::after {
        right: 8px;
        position: absolute;
    }

    th.sorted[data-order="-1"]::after {
        content: "▼"
    }

    th.sorted[data-order="1"]::after {
        content: "▲"
    }
</style>

<body>
    <h2>Введи информацию для заведения нового пользователя</h2>
    <form action="http://127.0.0.1/TestJob/admin.php" method="POST">
        Фамилия: <input type="text" name="last_name">
        Имя: <input type="text" name="first_name">
        Отчестов: <input type="text" name="patronymic">
        <p>
            <input type="submit" value="Добавить">
        </p>
    </form>


    <table class="table_sort" data-table="users">
        <thead>
            <tr>
                <th>id</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Статус</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_array($result_users)) {
            ?><tr data-id="<?= $row['id'] ?>">
                    <td class="id" data-field="id"><?= $row['id'] ?></td>
                    <td class="edit last_name" data-field="last_name"><?= $row['last_name'] ?></td>
                    <td class="edit" data-field="first_name"><?= $row['first_name'] ?></td>
                    <td class="edit" data-field="patronymic"><?= $row['patronymic'] ?></td>

                    <td data-field="status"> <?php if ($row['status'] == 'Первый') { 
                                            ?>
                                            <select class="status" name="status">
                                                <option selected><?= $row['status'] ?></option>
                                                <option>Второй</option>
                                                <option>Третий</option>
                                            </select>
                                            <?php } else if ($row['status'] == 'Второй') {
                                            ?>
                                            <select class="status" name="status">
                                                <option selected><?= $row['status'] ?></option>
                                                <option>Первый</option>
                                                <option>Третий</option>
                                            </select>
                                            <?php } else { 
                                                ?>
                                            <select class="status" name="status">
                                                <option selected><?= $row['status'] ?></option>
                                                <option>Первый</option>
                                                <option>Второй</option>
                                            </select>
                                            <?php } ?>                        
                    </td>
                </tr><?php
                    } ?>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const getSort = ({
                target
            }) => {
                const order = (target.dataset.order = -(target.dataset.order || -1));
                const index = [...target.parentNode.cells].indexOf(target);
                const collator = new Intl.Collator(['en', 'ru'], {
                    numeric: true
                });
                const comparator = (index, order) => (a, b) => order * collator.compare(
                    a.children[index].innerHTML,
                    b.children[index].innerHTML
                );

                for (const tBody of target.closest('table').tBodies)
                    tBody.append(...[...tBody.rows].sort(comparator(index, order)));

                for (const cell of target.parentNode.cells)
                    cell.classList.toggle('sorted', cell === target);
            };

            document.querySelectorAll('.table_sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));

        });
    </script>
    <script>
        $(document).ready(function() {


            $(document).on('click', 'td.edit', function() {

                if ($("#editbox").length > 0) {
                    return false;
                }

                $('.ajax').html($('.ajax input').val());
                $('.ajax').removeClass('ajax');

                let fieldName = $(this).attr('data-field');
                let dataId = $(this).parent('tr').data('id');
                $(this).addClass('ajax').html('<input data-id="' + dataId + '" data-fieldname="' + fieldName + '" class="form-control" id="editbox" size="' + $(this).text().length + '" type="text" value="' + $(this).text() + '" />');
                $('#editbox').focus();

            });



            $(document).on('keydown', '#editbox', function(e) {

                if (e.which == 13) {

                    var table = $(this).parents('table').data('table');
                    let fieldName = $(this).data('fieldname');
                    let dataId = $(this).data('id');

                    $.post("update_users.php", {

                        id: dataId,
                        field: fieldName,
                        value: $('.ajax input').val(),
                        table: table,

                    }, function(data) {
                        $('.ajax').html($('.ajax input').val());
                        $('.ajax').removeClass('ajax');
                    });
                }
            });

            $('.status').change(function() {

                data_value = $(this).val()
                var table = $(this).parents('table').data('table');
                let fieldName = $(this).parents('tr>td').data('field');
                let dataId = $(this).parents('tr').find('.id').html()
                console.info(data_value,table,fieldName,dataId)

                $.post("update_users.php", {
                    id: dataId,
                    field: fieldName,
                    value: data_value,
                    table: table,
                }, function(data) {
                    $('.ajax').html($('.ajax input').val());
                    $('.ajax').removeClass('ajax');
                });
            })
        });
    </script>

</body>

</html>