<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(htmlspecialchars($_POST['name']));
    $email = strip_tags(htmlspecialchars($_POST['email']));
    $text = strip_tags(htmlspecialchars($_POST['text']));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Некорректный email");
    }
    if (empty($name) || empty($email) || empty($text)) {
        die("Все поля обязательны для заполнения");
    }

    $mail = new PHPMailer(true);

    try {
        // Включить отладку (убрать в продакшене)
        // $mail->SMTPDebug = 2;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP сервер Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'Service@flamecoffee.eu'; // Ваш Gmail
        $mail->Password = 'msma sntm uqeq lxca'; // Пароль приложения
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS (можно также ENCRYPTION_SMTPS для SSL)
        $mail->Port = 587; // Порт для TLS

        // Настройка отправителя и получателя
        $mail->setFrom('Service@flamecoffee.eu', 'FlameCoffee');
        $mail->addReplyTo($email, $name);
        $mail->addAddress('Service@flamecoffee.eu', '123'); // Получатель

        // Настройки письма
        $mail->isHTML(false);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Новое сообщение с сайта';
        $mail->Body    = "Имя: $name\nЭлектронная почта: $email\nСообщение:\n$text";

        $mail->send();
        echo 'Сообщение отправлено успешно';
    } catch (Exception $e) {
        echo "Ошибка при отправке: {$mail->ErrorInfo}";
    }
}
?>
