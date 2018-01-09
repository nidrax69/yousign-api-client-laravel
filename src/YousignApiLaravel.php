<?php namespace Nidrax69\YousignApiLaravel;

use YousignAPI\YsApi;
use Illuminate\Support\Facades\Config;

class YousignApiLaravel extends YsApi {

  /**
   * Constructor
   */
   public function __construct(){
       parent::__construct(null);
       $this->setLogin(config('yousignapi.config.login'));
       if(!(config('yousignapi.config.isEncryptedPassword'))) {
           $this->setPassword($this->encryptPassword(config('yousignapi.config.password')));
       } else {
           $this->setPassword(config('yousignapi.config.username'));
       }
       $this->setApiKey(config('yousignapi.config.api_key'));
       $this->setEnvironment(config('yousignapi.config.environment'));

   }
   public function test() {
     var_dump(config('yousignapi.config.login'));
   }

}
