<?php

namespace app\components;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessRule
 *
 * @author bank
 */
class AccessRule extends \yii\filters\AccessRule{
    //put your code here
    protected function matchRole($user) {
        if(empty($this->roles)){
            return true;
        }

        foreach($this->roles as $role){
            if($role === '?'){
                if($user->getIsGuest()){
                    return true;
                }
            }else if($role === '@'){
                if(!$user->getIsGuest()){
                    return true;
                }
            }else if(!$user->getIsGuest() && $role === $user->identity->role){
                return true;
            }
        }
      return false;
    }
}
