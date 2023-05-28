<!--Header-->
<link rel="stylesheet" type="text/css" href="css/aut.css">
<?php include 'autRegHeader.php'; ?>

<!--Intro-->
<div class="intro">
    <div class="container">
        <div class="intro__inner">
            <form method="POST">
                <input name="username" type="text" class="feedback-input" placeholder="Enter username" required/>
                <input name="password" type="password" class="feedback-input" placeholder="Enter password"
                       required/>
                <input name="confirmPassword" type="password" class="feedback-input" placeholder="Confirm password"
                       required/>
                <button name="submit" type="submit">Ok</button>
            </form>
        </div>
        <div class="section__table">
            <?php
            if (isset($_POST["submit"])) {
                // Получение данных из формы
                $username = $_POST['username'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirmPassword'];

                // Проверка на совпадение пароля и его подтверждения
                if ($password === $confirm_password) {
                    // Хэширование пароля
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    //Определяем константы для дальшейшего доступа к базе данных
                    define('DB_HOST', 'localhost');
                    define('DB_USER', 'dasha');
                    define('DB_PASSWORD', '111');
                    define('DB_NAME', 'users');
                    //Проверяем установилось ли соединение
                    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                    if (!$conn) {
                        die("Ошибка подключения к БД: " . mysqli_connect_error());
                    }
                    // Установка кодировки UTF8
                    mysqli_set_charset($conn, "utf8");
                    // Проверка на наличие пользователя в БД
                    $query = "SELECT * FROM users WHERE username = '$username'";
                    $result = $conn->query($query);
                    if ($result->num_rows == 0) {
                        // Если пользователя нет, то добавляем его в БД
                        $insert_query = "INSERT INTO users (username, user_password) VALUES ('$username', '$hashed_password')";
                        $insert_result = $conn->query($insert_query);
                        if ($insert_result) {
                            session_start();
                            $_SESSION['username'] = $username;
                            header("Location: main.php");
                        } else {
                            echo "Ошибка при регистрации: " . $conn->error;
                        }
                    } else {
                        // Если пользователь уже есть, то обновляем его пароль
                        $update_query = "UPDATE users SET user_password = '$hashed_password' WHERE username = '$username'";
                        $update_result = $conn->query($update_query);
                        if ($update_result) {
                            echo "Пароль успешно обновлён!";
                        } else {
                            echo "Ошибка при обновлении пароля: " . $conn->error;
                        }
                    }
                    // Закрываем соединение с БД
                    $conn->close();

                } else {
                    echo "Пароль и его подтверждение не совпадают!";
                }
            }
            ?>
        </div>
    </div>
</div>



<!--Footer-->
<?php include 'footer.php'; ?>

