<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;

class FireBase {

    protected $serverToken  = "AAAAuilBPmU:APA91bFee83jiK7rVCa4e7JGtNLkdsXMk4TBaad1F93BUkKugkxFQGv5zMCPARIik8aUKDuqDWvVXtOluCxEoA1TSiZ6JKSzWXIiio78uUSfbWTFEInB9xy1pT99WoLiylv64vBRa_v0"; // Fire Base Server Key
    protected $serverUrl    = "https://fcm.googleapis.com/fcm/send"; // Fire Base URL
    protected $title        = "";
    protected $body         = "";
    protected $token        = [];
    protected $by           = "system";
    // ========================== //
    protected $message_to   = "all";
    // ========================== //
    protected $model_id     = 0;
    protected $model_type   = "";

    public function setModelId($model_id) {
        $this->model_id = $model_id;
        return $this;
    }

    public function setModelType($model_type) {
        $this->model_type = $model_type;
        return $this;
    }

    public function setSendBy($by) {
        $this->by = $by;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setBody($body) {
        $this->body = $body;
        return $this;
    }

    public function setToken($token) {
        $this->token = (is_array($token)) ? $token : [$token];
        return $this;
    }

    public function setMessageTo($message_to) {
        $this->message_to = $message_to;
        return $this;
    }

    private function getHeaders() {
        return [
            "Content-Type: application/json",
            "Authorization: key={$this->serverToken}",
        ];
    }

    private function getData() {
        return [
            'title'         => $this->title,
            'body'          => $this->body,
            'type'          => $this->by,
            'model_id'      => $this->model_id,
            'model_type'    => $this->model_type,
            'tickerText'    => '',
            'vibrate'       => 1,
            'sound'         => 1,
            'largeIcon'     => 'large_icon',
            'smallIcon'     => 'small_icon',
        ];
    }

    private function getFields() {
        if($this->message_to == "all") {
            $fields = [
                'notification' => $this->getData(),
                'to'    => '/topics/all'
            ];
        } else {
            $fields = [
                'registration_ids' => $this->token,
                'notification' => $this->getData()
            ];
        }
        return json_encode($fields);
    }

    public function build() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->serverUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->getFields());
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
