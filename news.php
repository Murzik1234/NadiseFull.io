<link rel="stylesheet" type="text/css" href="css/news.css">
<?php
//include "visitedPage.php";
session_start();
if (isset($_SESSION['username'])) {
    include 'header.php';
    ?>

    <section class="section">
        <div class="container1">
            <div class="section__info">
                <div class="section__text">
                    <?php
                    // Подключение к базе данных
                    $db_host = 'localhost';
                    $db_username = 'dasha';
                    $db_password = '111';
                    $db_name = 'lab8';

                    $conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
                    if (!$conn) {
                        die("Ошибка подключения к базе данных: " . mysqli_connect_error());
                    }

                    // Запрос к базе данных для получения данных
                    $query = "SELECT title, text, url FROM newspage WHERE id = 1";
                    $result = mysqli_query($conn, $query);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $title = $row['title'];
                        $description = $row['text'];
                        $image_src = $row['url'];

                        // Вывод данных из базы данных
                        echo "<h3>" . $title . "</h3>";
                        echo "<br>";
                        echo "<p>" . $description . "</p>";
                    }

                    // Закрытие соединения с базой данных
                    mysqli_close($conn);
                    ?>
                </div>
            </div>
            <div class="section__imgs">
                <?php
                // Вывод изображения из базы данных
                echo '<img src="' . $image_src . '" alt="" style="width: 100%">';
                ?>
            </div>
        </div>
    </section>
    <?php
    include 'footer.php';
} else {
    // Открываем страницу авторизации, если массив $_SESSION пуст
    header("Location: aut.php");
}
?>




