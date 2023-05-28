<footer>
    <?php
    $host = 'localhost';
    $db = 'lab8';
    $user = 'dasha';
    $password = '111';
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $query = "SELECT year, href, footer FROM footer";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Получение результата запроса в виде ассоциативного массива
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $year = $result['year'];
    $githubLink = $result['href'];
    $name = $result['footer'];
    ?>
    <p>&#169; <?php echo $year; ?> <a href="<?php echo $githubLink; ?>"><?php echo $name; ?></a></p>
</footer>
</body>
</html>