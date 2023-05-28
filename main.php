<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
//include "visitedPage.php";
session_start();
if (isset($_SESSION['username'])) {
    include 'header.php';
    $host = 'localhost';
    $db = 'lab8';
    $user = 'dasha';
    $password = '111';
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);

    $query = "SELECT title, text FROM mainpage";
    $stmt = $conn->prepare($query);
    $stmt->execute();

// Получение результата запроса в виде ассоциативного массива
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $title = $result['title'];
    $subtitle = $result['text'];

    ?>
    <!--Intro-->
    <div class="intro">
        <div class="container">
            <div class="intro__inner">
                <h1 class="intro__title"><?php echo $title;?></h1>
                <h2 class="intro__subtitle"><?php echo $subtitle;?></h2>
                <form method="POST">
                    <button name="submit" type="submit">See hotels</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['submit'])) {
        header("Location: hotels.php");
    }
    include 'footer.php';
} else {
//Открываем страницу авторизации если массив $_SESSION пуст
    header("Location: aut.php");
}
?>




