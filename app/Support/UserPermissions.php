<?php

namespace App\Support;

use Illuminate\Queue\Console\RetryCommand;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UserPermissions {

    public function getRoles() {
        return [
            User::TYPE_ADMIN,
            User::TYPE_CUSTOMER
        ];
    }

    public function getPermissions() {
        $models = $this->getModels();
        $array = [];
        foreach($models as $k=>$v) {
            if(empty($array)) {
                if(count(array_values($v)) > 1) {
                    foreach ($v as $i) {
                        $array = array_values($v);
                    }
                } else {
                    $array = array_values($v)[0];
                }
            } else {
                if(count(array_values($v)) > 1) {
                    foreach ($v as $i) {
                        $array = array_merge($array,array_values($i));
                    }
                } else {
                    $array = array_merge($array,array_values($v)[0]);
                }
            }
        }
        return $array;
    }

    public function getPermissionsByKey() {
        $models = $this->getModels();
        $array = [];
        foreach($models as $k=>$v) {
            if(empty($array)) {
                $array = $v;
            } else {
                $array = array_merge($array,$v);
            }
        }
        return $array;
    }

    private function getModels() {
        $files = $this->getFiles();
        $array = [];
        foreach ($files as $file) {
            $array[] = (new ("\\App\\Models\\".str_replace(["/","\\"],"",$file)))->getModePermissions();
        }
        return $array;
    }

    private function getFiles() {
        $files = [];
        foreach (glob(app_path("Models")."/*.php") as $file) {
            $files[] = _fixDirSeparator(str_replace([app_path("Models"),"\\",".php"],"",$file));
        }
        return $files;
    }
}
