<?php namespace Nidrax69\YousignApiLaravel;

use YousignAPI\YsApi;
use Illuminate\Support\Facades\Config;

class YousignApiLaravel extends YsApi {

  /**
   * Constructor
   */
  public function __construct(){
      parent::__construct(null);
      $this->setLogin('yousignapi.config.login');
      if(!('yousignapi.config.isEncryptedPassword')) {
          $this->setPassword($this->encryptPassword('yousignapi.config.password'));
      } else {
          $this->setPassword('yousignapi.config.username');
      }
      $this->setApiKey('yousignapi.config.api_key');
      $this->setEnvironment('yousignapi.config.environment');
  }


}
