<?php
class message
{

    private $curentMessage = "";

    function __construct()
    {
    }

    function setMessage(string $message, string $type = 'error')
    {

        $this->curentMessage =  '<div class="upload_ko" onclick="$(this).hide();">';
        if ($type != 'error') $this->curentMessage =  '<div class="upload_ok" onclick="$(this).hide();">';
        $this->curentMessage .=  $message;
        $this->curentMessage .= '</div>';
    }

    function getMessage(){
        return $this->curentMessage;
    }
}
