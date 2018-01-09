<?php namespace Nidrax69\YousignApiLaravel;

use YousignAPI\YsApi;
use Illuminate\Support\Facades\Config;

class YousignApiLaravel extends YsApi {

  /**
   * Constructor
   */
   public function __construct(){
       parent::__construct(null);
       $this->setLogin(config('yousign.login'));
       if(!(config('yousign.isEncryptedPassword'))) {
           $this->setPassword($this->encryptPassword(config('yousign.password')));
       } else {
           $this->setPassword(config('yousign.username'));
       }
       $this->setApiKey(config('yousign.api_key'));
       $this->setEnvironment(config('yousign.environment'));

   }
   public function test() {
     var_dump(config('yousign.login'));
   }

}
