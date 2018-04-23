<?php

class Sender
{

    private $ch;
    private $response = false;

    public function __construct($url, $options = null)
    {
        $this->ch = curl_init($url);
 
        //building headers for the request
        $headers = array(
            'Authorization: key=' . 'AIzaSyCa7HKU5PXfBixG3r7Yq0uEhe4h6-mWP-E',
            'Content-Type: application/json'
        );        

        // foreach ($options as $key => $val) {
        //     curl_setopt($this->ch, $key, $val);
        // }

        //Setting the curl url
        curl_setopt($this->ch, CURLOPT_URL, $url);
        
        //setting the method as post
        curl_setopt($this->ch, CURLOPT_POST, true);

        //adding headers 
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
 
        //disabling ssl support
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format 
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($options));
        
        $result = curl_exec($this->ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($this->ch));
        }
 
        //Now close the connection
        curl_close($this->ch);
    }

    public function getResponse()
    {
         if ($this->response) {
             return $this->response;
         }

        $response = curl_exec($this->ch);
        $error    = curl_error($this->ch);
        $errno    = curl_errno($this->ch);

        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }

        // if (0 !== $errno) {
        //     throw new \RuntimeException($error, $errno);
        // }

        return $this->response = $response;
    }

    public function __toString()
    {
        return $this->getResponse();
    }
}
