<?php

class HttpClient
{
    private mixed $curl;
    private array $header = array();

    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        return $this;
    }

    public function __destruct()
    {
        if(!empty($this->curl))
        {
            curl_close($this->curl);
            $this->curl = null;
        }
    }

    public function SetHeader(array|null $header)
    {
        $this->header = $header;
        return $this;
    }

    public function RequestGet(string $url, array|null $param = null)
    {
        if(!is_null($param))
        {
            $query = http_build_query($param);
            $parse = parse_url($url);
            if(!empty($parse['query']))
            {
                $url .= '&' . $query;
            }
            else
            {
                $url .= '?' . $query;
            }
        }
        return $this->Request($url, $param);
    }

    public function RequestPost(string $url, array|null $param = null)
    {
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $param);
        return $this->Request($url, $param);
    }

    public function RequestPut(string $url, array|null $param = null)
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $param);
        return $this->Request($url, $param);
    }

    public function RequestPatch(string $url, array|null $param = null)
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $param);
        return $this->Request($url, $param);
    }

    public function RequestDelete(string $url, array|null $param = null)
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $param);
        return $this->Request($url, $param);
    }

    private function Request(string $url, array|null $param = null)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->header);
        $response = curl_exec($this->curl);
        if(is_null($response)) return null;
        return json_decode($response, true);
    }
}