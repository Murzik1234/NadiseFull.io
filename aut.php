<!--Header-->
<link rel="stylesheet" type="text/css" href="css/aut.css">
<?php include 'autRegHeader.php'; ?>

<!--Intro-->
<div class="intro">
    <div class="container">
        <div class="intro__inner">
            <form method="POST">
                <input name="username" type="text" class="feedback-input" placeholder="Username" required/>
                <input name="password" type="password" class="feedback-input" placeholder="Password"
                       required/>
                <button name="submit" type="submit">Ok</button>
            </form>
        </div>
        <div class="section__table">
            <?php
            //include "visitedPage.php";
            error_reporting(E_ERROR);
            class AuthenticationSystem {
                private $db;
                //Конструктор класса
                public function __construct() {
                    $this->db = new mysqli("localhost", "dasha", "111", "users");
                    //Если соединение с базой данных не установилось
                    if ($this->db->connect_errno) {
                        die("Failed to connect to MySQL: " . $this->db->connect_error);
                    }
                }
                //Функция которая проверяем логин и пароль из бызы данных и введенные пользователем
                public function login($username, $password) {
                    //Делаем запрос к базе данных
                    $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                    $stmt->close();
                    //Проверяем соответсвие паролей
                    if (password_verify($password, $user['user_password'])) {
                        //Начинаем сессию
                        session_start();
                        $_SESSION['username'] = $username;
                        return true;
                    } else {
                        return false;
                    }
                }
                public function isLoggedIn() {
                    session_start();
                    return isset($_SESSION['username']);
                }
                //Функция которая закрывает сессию
                public function logout() {
                    session_start();
                    session_destroy();
                }
                //Деструктор класса
                public function __destruct() {
                    $this->db->close();
                }
            }
            //Создаём объект класса AuthenticationSystem
            $auth = new AuthenticationSystem();
            //Если пользователь не авторизован, то закррываем сессию
            if ($_GET['action'] === 'logout'){
                $auth->logout();
            }
            if (isset($_POST["submit"])) {
                // Получение данных из формы
                $username = $_POST['username'];
                $password = $_POST['password'];
                //Если логин и пароль совпадают то пользователь авторизовался
                if ($auth->login($username, $password)) {
                    header("Location: main.php");
                } else {
                    echo "Неверный логин или пароль!";
                }
                //Проверяем авторизован ли пользователь
                if ($auth->isLoggedIn()) {
                    echo "Вы авторизованы!";
                } else {
                    echo "Вы не авторизованы!";
                }
            }
            ?>
        </div>
    </div>
</div>



<!--Footer-->
<?php include 'footer.php'; ?>

