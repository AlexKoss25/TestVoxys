<?php
require_once 'link.php';

if (isset($_GET['last_name'], $_GET['first_name'], $_GET['patronymic'], $_GET['status'])) {

    $input_last_name = $_GET['last_name'];
    $input_first_name  = $_GET['first_name'];
    $input_patronymic  = $_GET['patronymic'];
    $input_status  = $_GET['status'];
}

$sqlAdd = '';
if (!empty($input_last_name)) {
    $sqlAdd = $sqlAdd . " AND `last_name` LIKE '%$input_last_name%' ";
}
if (!empty($input_first_name)) {
    $sqlAdd = $sqlAdd . " AND `first_name` LIKE '%$input_first_name%' ";
}
if (!empty($input_patronymic)) {
    $sqlAdd = $sqlAdd . " AND `patronymic` LIKE '%$input_patronymic%' ";
}
if (!empty($input_status)) {
    $sqlAdd = $sqlAdd . " AND `status` LIKE '%$input_status%' ";
}
$sql_search_users = "SELECT * FROM `users` WHERE 1=1 " . $sqlAdd;


$result_users = mysqli_query($link, $sql_search_users);

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" >
    <title>Нашли</title>
</head>

<body>
    
    <div class="text-search">
        <h2>Введи информацию для поиска пользователя</h2>
    </div>
    <div class="form-search">
        <form action="http://127.0.0.1/TestJob/search.php">
            Фамилия: <input type="text" name="last_name">
            Имя: <input type="text" name="first_name">
            Отчестов: <input type="text" name="patronymic">
            Статус: <select name="status">
                <option disabled>Выбирете нужный статус:</option>
                <option value="Первый">Первый</option>
                <option value="Второй">Второй</option>
                <option value="Третий">Третий</option>
                <option selected value="">Поиск без учёта статуса</option>
            </select>
            <input type="submit" value="Поиск" style="margin-left: 50px;">
            <p></p>
        </form>
    </div>
    <div class="table-search">
        <table class="table_sort">
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
                while ($users = mysqli_fetch_array($result_users)) {
                ?><tr>
                        <td><?= $users[0] ?></td>
                        <td><?= $users[1] ?></td>
                        <td><?= $users[2] ?></td>
                        <td><?= $users[3] ?></td>
                        <td><?= $users[4] ?></td>
                    </tr><?php
                        }
                            ?>
            </tbody>
        </table>
    </div>
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
    
    
    <div class="info-search">        
        <span class="info-block">&nbsp;&nbsp;&nbsp;&nbsp;На данной странице реализован второй модуль «Для пользователей». В таблице находятся все занесенные пользователи и их статусы.
Реализована возможность поиска по ФИО или статусу. Поиск запускается после нажатия кнопки "Поиск". Также при нажатии на название столбца, данные сортируются.</span>
    </div>
    
</body>



</html>