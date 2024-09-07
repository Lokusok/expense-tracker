<?php

define("ASSETS_PATH", __DIR__ . "/resources");
define("ASSETS_CSS", ASSETS_PATH . "/css");
define("ASSETS_IMAGES", ASSETS_PATH . "/images");

require __DIR__ . "/functions.php";

use App\Http\Router\Router;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;

use App\Containers\Database\DatabaseContainer;
use App\Containers\Email\EmailContainer;

use PHPMailer\PHPMailer\PHPMailer;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

// Инициализация контейнера БД
$dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}";
DatabaseContainer::set('db', new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']));

// Инициализация контейнера отправки почты
$mail = new PHPMailer(true);

$mail->isSMTP();

$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = $_ENV['SMTP_EMAIL'];
$mail->Password = $_ENV['SMTP_PASSWORD'];
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS
$mail->Port = 587;

EmailContainer::set('smtp', $mail);

$router = new Router();

$router->get("/", [IndexController::class, 'index']);

$router->get("/expenses", [ExpensesController::class, 'index']);
$router->post("/expenses", [ExpensesController::class, 'store']);
$router->delete("/expenses/delete", [ExpensesController::class, 'destroy']);
$router->put("/expenses/edit", [ExpensesController::class, 'edit']);

$router->get("/profile", [ProfileController::class, 'index']);
$router->patch("/profile/update", [ProfileController::class, 'update']);

$router->get("/profile/recover", [PasswordController::class, 'recover']);
$router->post("/profile/recover-password", [PasswordController::class, 'recoverPassword']);
$router->post("/profile/change-password", [PasswordController::class, 'changePassword']);

$router->get("/login", [SessionController::class, 'index']);
$router->post("/login", [SessionController::class, 'login']);
$router->delete("/logout", [SessionController::class, 'logout']);

$router->get("/register", [RegisterController::class, 'index']);
$router->post("/register", [RegisterController::class, 'store']);


$method = $_SERVER["REQUEST_METHOD"];
$url = explode("?", $_SERVER["REQUEST_URI"])[0];

if (isset($_POST["_method"])) {
  $method = $_POST["_method"];
}

$router->resolve($url, strtolower($method));
