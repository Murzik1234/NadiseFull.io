<!--Header-->

<link rel="stylesheet" type="text/css" href="css/reservation.css">
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
    $query = "SELECT title, h3, h4, p, number FROM bookingpage";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $result['title'];
    $h3 = $result['h3'];
    $h4 = $result['h4'];
    $p = $result['p'];
    $number = $result['number'];

    ?>
    <!--Intro-->
    <section class="section">
        <div class="container">
            <div class="section__header">
                <h2 class="section__title"><?php echo $title;?></h2>
            </div>
            <div class="section__info">

                <div class="section__text">
                    <h3><?php echo$h3;?></h3>
                    <p></p>
                    <h4><?php echo $h4;?></h4>
                    <p><?php echo $number; ?></p>
                    <p><?php echo $p; ?></p>
                </div>

                <div class="section__res">
                    <form method="POST">
                        <select name="myDropdown" class="feedback-input">
                            <?php

                            // Шаг 1: Получение данных из базы данных
                            $query = $conn->query("SELECT id, title FROM hotels");
                            if (!$query) {
                                die('Ошибка выполнения запроса: ' . $conn->errorInfo());
                            }

                            // Шаг 2: Создание элементов <option>
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                $id = $row['id'];
                                $name = $row['title'];
                                echo "<option value='$id'>$name</option>";
                            }
                            ?>
                        </select>
                        <input name="date" type="date" class="feedback-date" min="<?php echo date('Y-m-d'); ?>"
                               placeholder="Date" required/>
                        <input name="persons" type="number" min="1" max="100" class="feedback-input"
                               placeholder="Count persons" required/>
                        <input name="nights" type="number" min="2" max="100" class="feedback-input"
                               placeholder="Count nights" required/>
                        <input name="name" type="text" class="feedback-input" placeholder="Name" required/>
                        <button name="submit" type="submit">Ok</button>
                    </form>

                </div>


            </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $selectedId = $_POST['myDropdown']; // Получаем значение ID выбранного элемента из выпадающего списка
                $selectedName = ""; // Переменная для хранения выбранного имени

                // Шаг 1: Получение данных из базы данных
                $query = $conn->prepare("SELECT id, title FROM hotels WHERE id = ?");
                $query->execute([$selectedId]);

                if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $selectedName = $row['title']; // Получаем выбранное имя из базы данных
                }

                $date = $_POST['date'];
                $countPersons = $_POST['persons'];
                $countNights = $_POST['nights'];
                $name = $_POST['name'];


                // Создание SQL-запроса для вставки данных в базу данных
                $query = $conn->prepare("INSERT INTO orders (name, days, persons, date, hotel) VALUES (?, ?, ?, ?, ?)");

                // Выполнение SQL-запроса с передачей значений
                $query->execute([$name, $countNights, $countPersons, $date, $selectedName]);

                // Проверка успешности выполнения запроса
                if ($query) {
                    echo "Поздравляем! Вы успешно сделали бронь!";
                } else {
                    echo "Ошибка при добавлении данных в базу данных.";
                }
            }
            ?>
        </div>
    </section>
    <?php
// Проверка, была ли отправлена форма


    include 'footer.php';
} else {
//Открываем страницу авторизации если массив $_SESSION пуст
    header("Location: aut.php");
}
?>








