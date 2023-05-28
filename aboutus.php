<!--Header-->
<?php
// Подключение к базе данных
$host = 'localhost';
$db = 'lab8';
$user = 'dasha';
$password = '111';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);

$query = "SELECT context FROM aboutUsPage";
$stmt = $conn->prepare($query);
$stmt->execute();

// Получение результата запроса в виде ассоциативного массива
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$context = $result['context'];

?>
<link rel="stylesheet" type="text/css" href="css/AboutUs.css">
<?php
session_start();
if (isset($_SESSION['username'])) {
    include 'header.php';
    ?>

    <!--Section-->
    <section class="section">
        <?php echo $context ?>
    </section>

    <!--Footer-->
    <?php


    include 'footer.php';
} else {
//Открываем страницу авторизации если массив $_SESSION пуст
    header("Location: aut.php");
}
?>
