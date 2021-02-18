<?php

use Garphild\AuthTelegram\TelegramAuthentificator;

require_once "../vendor/autoload.php";
require_once "config.php";

require_once "database.php";
require_once "sendMessage.php";

$tgAuth = new TelegramAuthentificator(USERNAME_BOT, TOKEN_BOT, OAUTH_CONFIG);

try {
    $tgAuth->logIn($_GET);
    setcookie(COOKIE_NAME, json_encode($tgAuth->user));
    new SendMessage($tgAuth->user);
} catch (Exception $e) {
    $err = array(
        'ok' => false,
        'message' => $e->getMessage()
    );

    die(json_encode($err));
}

header('Location: login.php');
