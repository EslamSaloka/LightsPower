<?php 

namespace App\Models\Trait\User;

trait HasApiToken {

    public function tokens() {
        return $this->hasMany(\App\Models\User\Token::class,"user_id","id");
    }
    
    public function setApiToken() {
        $token = $this->tokens()->where(["devices_token"=>request()->header("devices-token")])->first();
        if(is_null($token)) {
            $this->tokens()->create([
                "token"         => generate_api_token(),
                "devices_token" => request()->header("devices-token"),
            ]);
        } else {
            $token->update([
                "token"         => generate_api_token(),
            ]);
        }
        return $this;
    }

    public function deleteTokens() {
        $this->tokens()->delete();
        return $this;
    }

    public function deleteToken() {
        $this->tokens()->where(["devices_token"=>request()->header("devices-token")])->delete();
        return $this;
    }

    public function getApiTokenAttribute() {
        return $this->tokens()->where(["devices_token"=>request()->header("devices-token")])->first()->token ?? '';
    }

}