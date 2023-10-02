<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/phpmailer/Exception.php';
require 'vendor/phpmailer/PHPMailer.php';
require 'vendor/phpmailer/SMTP.php';

if (isset($_POST['g-recaptcha-response']))
    $captcha = $_POST['g-recaptcha-response'];

//if (!$captcha) {
//    echo '<h2>Каптча не установлена.</h2>';
//    exit;
//}

//$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=63198549-a5f5-4a62-a6f4-9b393989dd2b&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);
//if ($response['success'] == false) {
//    echo '<h2>Проверка каптчи не пройдена!</h2>';
//} else {
if (!error_get_last()) {
    $name = strip_tags(htmlentities($_POST['name']));
    $email = strip_tags(htmlentities($_POST['email']));
    $phone = strip_tags(htmlentities($_POST['phone']));
    $cv = $_FILES['cv'];

    $tg_user = '@romamilash';
    $bot_token = '6417513040:AAHxLYmSurjYklLIlTQ85cQ9kJmDqaTlMpo';

    $text = "Новое резюме от {$name}. Email: {$email}, Телефон: {$phone}.";

// параметры, которые отправятся в api телеграмм
    $params = array(
        'chat_id' => $tg_user, // id получателя сообщения
        'text' => $text, // текст сообщения
        'parse_mode' => 'HTML', // режим отображения сообщения, не обязательный параметр
    );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $bot_token . '/sendMessage');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    $result = curl_exec($curl);
    curl_close($curl);

    var_dump(json_decode($result));

    array_push($params, ['document' => curl_file_create($cv['tmp_name'][0], 'application/msword', $cv['name'])]);

    curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $bot_token . '/sendDocument');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    $result = curl_exec($curl);
    curl_close($curl);

    var_dump(json_decode($result));

    $title = "Резюме с сайта";
    $body = "
    <h2>Резюме с сайта</h2>
    <b>Имя:</b> $name<br>
    <b>Почта:</b> $email<br>
    <b>Телефон:</b> $phone<br>
    ";

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth = true;
    $mail->Debugoutput = function ($str, $level) {
        $GLOBALS['data']['debug'][] = $str;
    };

    $mail->Host = 'smtp.yandex.ru';
    $mail->Username = 'romamilash';
    $mail->Password = '';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('romamilash@yandex.ru', 'Roma Milash');

    $mail->addAddress('roma@milash.info');

    if (!empty($cv['name'][0])) {
        $mail->addAttachment($cv['tmp_name'][0], $cv['name'][0]);
    }
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    if ($mail->send()) {
        $data['result'] = "success";
        $data['info'] = "Сообщение успешно отправлено!";
    } else {
        $data['result'] = "error";
        $data['info'] = "Сообщение не было отправлено. Ошибка при отправке письма";
        $data['desc'] = "Причина ошибки: {$mail->ErrorInfo}";
    }

} else {
    $data['result'] = "error";
    $data['info'] = "В коде присутствует ошибка";
    $data['desc'] = error_get_last();
}

header('Content-Type: application/json');
echo json_encode($data);

//}