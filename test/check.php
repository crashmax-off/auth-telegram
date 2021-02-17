<?php

use Garphild\AuthTelegram\TelegramAuthentificator;

require_once "../vendor/autoload.php";
require_once "config.php";

$tgAuth = new TelegramAuthentificator(USERNAME_BOT, TOKEN_BOT, OAUTH_CONFIG);

try {
    $tgAuth->logIn($_GET);
    setcookie(COOKIE_NAME, json_encode($tgAuth->user));

    $arr = array(
        'first_name: ' => htmlspecialchars($tgAuth->user->first_name),
        'last_name: ' => htmlspecialchars($tgAuth->user->last_name),
        'username:' => htmlspecialchars($tgAuth->user->username),
        'id:' => $tgAuth->user->id
    );

    foreach ($arr as $key => $value) {
        $txt .= "*" . $key . "* " . $value . "%0A";
    }

    file_get_contents("https://api.telegram.org/bot" . TOKEN_BOT . "/sendMessage?chat_id=" . CHAT_ID . "&parse_mode=markdown&text={$txt}");
} catch (Exception $e) {
    die(json_encode(array(
        'ok' => false,
        'message' => $e->getMessage()
    )));
}

header('Location: login.php');
