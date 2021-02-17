<?php

use Garphild\AuthTelegram\Models\TelegramUserModel;
use Garphild\AuthTelegram\TelegramAuthentificator;

require_once "../vendor/autoload.php";
require_once "config.php";

$tgAuth = new TelegramAuthentificator(USERNAME_BOT, TOKEN_BOT, OAUTH_CONFIG);

if (isset($_COOKIE[COOKIE_NAME])) {
    $tgAuth->setUser(new TelegramUserModel(json_decode($_COOKIE[COOKIE_NAME], true)));
}

if (isset($_GET['logout']) && $tgAuth->user->auth_date === $_GET['logout']) {
    $tgAuth->logOut();
    setcookie(COOKIE_NAME, null);
    header('Location: login.php');
}

if ($tgAuth->isAuthentificated()) {
    $userdata = json_encode($tgAuth->user);
    $first_name = htmlspecialchars($tgAuth->user->first_name);
    $last_name = htmlspecialchars($tgAuth->user->last_name);

    if (isset($tgAuth->user->photo_url)) {
        $photo_url = htmlspecialchars($tgAuth->user->photo_url);
        $html = "<div class=\"avatar\"><img src=\"{$photo_url}\"></div>";
    }

    if ($tgAuth->user->username) {
        $username = htmlspecialchars($tgAuth->user->username);
        $html .= "<div class=\"username\"><a href=\"https://t.me/{$username}\" target=\"_blank\">{$first_name} {$last_name}</a></div>";
    } else {
        $html .= "<div class=\"username\">{$first_name} {$last_name}!</div>";
    }

    $html .= "<div><a href=\"?logout={$tgAuth->user->auth_date}\">Выйти</a></div>";
} else {
    $html = $tgAuth->getWidget();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&amp;display=swap" rel="stylesheet">
    <title>Telegram OAuth</title>
    <script>
        function onTelegramAuth(user) {
            console.log(user);
            alert('Logged in as ' + user.first_name + ' ' + user.last_name + ' (' + user.id + (user.username ? ', @' + user.username : '') + ')');
        }
    </script>
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
            color: #24292e;
        }

        body {
            color: #111;
            background-color: #fdfdfd;
            box-sizing: border-box;
            min-width: 200px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0px 40px 40px 40px;
            background-color: #f6f8fa;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 0px 5px 5px 5px;
            }

            body>.container {
                padding: 20px !important;
            }
        }

        .container {
            border: 1px solid #e1e4e8;
            padding: 16px 16px;
            border-radius: 6px;
            margin-left: auto;
            margin-right: auto;
            background-color: #fff;
            margin: 16px 0px 16px 0px !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar {
            display: flex;
        }

        .avatar>img {
            width: 48px;
        }

        .username {
            margin-left: 20px;
            flex: 1;
        }

        .avatar>img {
            border-radius: 2rem;
        }

        a {
            color: #0366d6;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        textarea {
            resize: none;
            border-radius: 6px;
            border: 1px solid #e1e4e8;
            width: 100%;
            height: 5rem;
        }

        iframe {
            padding: 4px 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <? echo $html ?>
    </div>
    <?php if ($tgAuth->isAuthentificated()) : ?>
        <div class="container">
            <textarea disabled><?= $userdata ?></textarea>
        </div>
    <?php endif; ?>
</body>

</html>