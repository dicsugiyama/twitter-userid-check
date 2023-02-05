<?php

class Slack 
{
    private string $url;
    private string $channel;
    private string $botname;
    private string $member_id;

    public function __construct()
    {
        $this->url = SLACK_URL;
        $this->channel = SLACK_CHANNEL;
        $this->botname = SLACK_BOTNAME;
        $this->member_id = SLACK_MEMBER_ID;
        return $this;
    }

    public function Notify(string $message, bool $reply_flag = false, string|null $url = null)
    {
        if(is_null($url)) $url = $this->url;
        if($reply_flag) $message = $this->member_id . ' ' . $message;
        $param = [
            "channel" => $this->channel,
            "username" => $this->botname,
            "text" => "",
            "attachments" => [
                "blocks" => [
                    "color" => "#1DA1F2",
                    "type" => "section",
                    "text" => $message,
                ],
            ],
        ];
        $response = (new HttpClient())
        ->RequestPost($url, ['payload' => json_encode($param)]);
    }
}