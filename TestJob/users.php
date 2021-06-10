<?php
    require_once 'link.php';

    $sql_all = "SELECT * FROM `users`";
    
    $result_all = mysqli_query($link, $sql_all);
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css" >  
        <title>Всё</title>
    </head>
    
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