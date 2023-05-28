<?php
// Подключение к базе данных
$host = 'localhost';
$db = 'lab8';
$user = 'dasha';
$password = '111';
$conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);

// SQL-запрос для извлечения пунктов меню
$query = "SELECT * FROM navbar1";
$stmt = $conn->prepare($query);
$stmt->execute();

// Получение результата запроса в виде ассоциативного массива
$menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT title, h2 FROM header";
$stmt = $conn->prepare($query);
$stmt->execute();

// Получение результата запроса в виде ассоциативного массива
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$title = $result['title'];
$subtitle = $result['h2'];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@300&family=Pacifico&family=Source+Sans+Pro&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <title><?php echo $title; ?></title>
</head>
<body>


<!--Header-->
<header class="header">
    <div class="container">
        <div class="header__inner">
            <div class="header__title">
                <h2><?php echo $subtitle; ?></h2>
            </div>
            <nav>
                <input type="checkbox" name="toggle" id="menu" class="toggleMenu">
                <label for="menu" class="toggleMenu"><i class="fa fa-bars"></i></label>
                <ul class="nav">
                    <?php foreach ($menuItems as $menuItem): ?>
                        <li><a class="nav__link"
                               href="<?php echo $menuItem['url']; ?>"><?php echo $menuItem['title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </div>
</header>



