<?php

class Twitter 
{
    private string $api_token;

    public function __construct()
    {
        $this->api_token = TWITTER_API_TOKEN;
        return $this;
    }

    public function ExistsUsername(string $username)
    {
        $userdata =  $this->LookupUser($username);
        if(empty($userdata['errors']))
        {
            return true;
        }
        return false;
    }

    public function LookupUser(string $username)
    {
        return (new HttpClient())
        ->SetHeader([
            'Authorization: Bearer ' . $this->api_token,
            'Content-Type: application/json',
        ])
        ->RequestGet('https://api.twitter.com/2/users/by/username/' . $username);
    }
}