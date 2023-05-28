<!--Header-->
<link rel="stylesheet" type="text/css" href="css/menu.css">
<?php
//include "visitedPage.php";
session_start();
if (isset($_SESSION['username'])) {
    include 'header.php';
// Получение значений из базы данных (пример)
    $dbHost = 'localhost';
    $dbUser = 'dasha';
    $dbPass = '111';
    $dbName = 'lab8';

    $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Запрос для получения всех записей из таблицы "sections"
    $query = "SELECT title, caption, description FROM hotels";
    $result = mysqli_query($conn, $query);
    ?>
    <section class="section">
        <div class="container1">
            <?php
            if (mysqli_num_rows($result) > 0) {
                // Цикл для обхода всех записей
                while ($row = mysqli_fetch_assoc($result)) {
                    // Извлечение значений из текущей записи
                    $title = $row['title'];
                    $imageSrc = $row['caption'];
                    $description = $row['description'];

                    // Вывод HTML-кода с использованием значений из базы данных

                    echo '<div class="section__info">';
                    echo '<div class="section__text">';
                    echo "<h3>$title</h3>";
                    echo '</div>';
                    echo '<div class="section__item">';
                    echo '<div class="section__imgs">';
                    echo "<img src=\"$imageSrc\" alt=\"\" style=\"width: 100%\">";
                    echo '</div>';
                    echo "<div class=\"about__text\">$description</div>";
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </section>
    <?php
// Закрытие соединения с базой данных
    mysqli_close($conn);
    include 'footer.php';
} else {
//Открываем страницу авторизации если массив $_SESSION пуст
    header("Location: aut.php");
}
?>







