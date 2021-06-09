<?php
    require_once 'link.php';

    $sql_all = "SELECT * FROM `users`";
    
    $result_all = mysqli_query($link, $sql_all);
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">  
        <title>Всё</title>
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
                        while ($all = mysqli_fetch_array($result_all)) {
                            ?><tr>
                                <td><?= $all[0] ?></td>
                                <td><?= $all[1] ?></td>
                                <td><?= $all[2] ?></td>
                                <td><?= $all[3] ?></td>
                                <td><?= $all[4] ?></td> 
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