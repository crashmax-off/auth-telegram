# Auth by telegram

PHP wrapper for the Telegram login widget.
The Telegram login widget is a simple way to authorize users on your website.

Useful links:
* [How to create bot](https://core.telegram.org/bots#3-how-do-i-create-a-bot)
* [More about telegram login](https://core.telegram.org/widgets/login)


Features:

* async/sync load
* different button sizes
* user's photo
* configurable button corner radius
* authentificate result can be sent to callback or reirection url
* get write to user permission

## Constructor params
* **$botName**: string - bot name
* **$botKey**: string - bot auth key
* **$cookieName**: string - cookie name to store auth data
* **$config**: string - config array for widget

## Config options
* **size**: string enum('large', 'medium', 'small'] - size of button
* **userPhoto**: boolean - get user's photo in auth result
* **cornerRadius**: number - button corner radius
* **resultActionType**: string enum('callback', 'url') - button corner radius
* **resultAction**: string - callback javascript function name or url to redirect
* **requestWrite**: boolean - allow get write messages to user permission
* **async**: boolean - allow async script load
* **maxAge**: number - max age of auth data to be actual

## Public properties
* **user** TelegramUserModel - authentificated user data or null

## Public methods
* **isAuthentificated(): boolean** - check if user authentificated (based on cookie)
* **getWidget(): string** - get widget html code
* **logOut(): void** - clear cookie and user data
* **setUser(TelegramUserModel $user): void** - set current user
* **clearUser(): void** - clear current user
* **checkTelegramAuthorization($auth_data): void** - check data from telegram