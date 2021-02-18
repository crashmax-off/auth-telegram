<?php

class SendMessage
{

    protected $data = null;
    protected $message = '';

    protected $chat_id = CHAT_ID;
    protected $token_bot = TOKEN_BOT;

    function __construct($data)
    {
        $this->data = $data;

        if ($this->data !== null) {
            $this->send();
        } else {
            throw new \Exception("Wrong sendMessage!");
        }
    }

    protected function send()
    {
        $arr = array(
            'first_name: ' => htmlspecialchars($this->data->first_name),
            'last_name: ' => htmlspecialchars($this->data->last_name),
            'username:' => htmlspecialchars($this->data->username),
            'id:' => $this->data->id
        );

        foreach ($arr as $key => $value) {
            $this->message .= "*" . $key . "* " . $value . "%0A";
        }

        file_get_contents("https://api.telegram.org/bot{$this->token_bot}/sendMessage?chat_id={$this->chat_id}&parse_mode=markdown&text={$this->message}");
    }
}
