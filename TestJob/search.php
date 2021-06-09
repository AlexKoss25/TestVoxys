<?php
    require_once 'link.php';
    
    if (isset ($_GET['last_name'], $_GET['first_name'], $_GET['patronymic'],$_GET['status'])) {
        
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
        $sqlAdd = $sqlAdd." AND `first_name` LIKE '%$input_first_name%' ";
    }
    if (!empty($input_patronymic)) {
        $sqlAdd = $sqlAdd." AND `patronymic` LIKE '%$input_patronymic%' ";
    }
    if (!empty($input_status)) {
        $sqlAdd = $sqlAdd." AND `status` LIKE '%$input_status%' ";
    }
    $sql_search_users = "SELECT * FROM `users` WHERE 1=1 ".$sqlAdd;    

  
    $result_users = mysqli_query($link, $sql_search_users);        

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <title>Нашли</title>
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
        <h2>Введи информацию для поиска пользователя</h2>
            <form action="http://127.0.0.1/TestJob/search.php">
                Фамилия: <input type="text" name="last_name">
                Имя: <input type="text" name="first_name">
                Отчестов: <input type="text" name="patronymic">
                Статус: <input type="int" name="status">  
                <p>
                    <input type="submit" value="Поиск">
                </p>
        </form>
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
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const getSort = ({ target }) => {
                    const order = (target.dataset.order = -(target.dataset.order || -1));
                    const index = [...target.parentNode.cells].indexOf(target);
                    const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
                    const comparator = (index, order) => (a, b) => order * collator.compare(
                        a.children[index].innerHTML,
                        b.children[index].innerHTML
                    );
                    
                    for(const tBody of target.closest('table').tBodies)
                        tBody.append(...[...tBody.rows].sort(comparator(index, order)));

                    for(const cell of target.parentNode.cells)
                        cell.classList.toggle('sorted', cell === target);
                };

                document.querySelectorAll('.table_sort thead').forEach(tableTH => tableTH.addEventListener('click', () => getSort(event)));

                });
        </script>
    </body>
</html>