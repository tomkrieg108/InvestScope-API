<?php

class Core {
  //Set defaults - these change when url changes
  protected $currentControllerName_ = 'Pages'; 
  protected $currentController_;
  protected $currentMethod_ = 'Index';
  protected $params_ = [];

  public function __construct() {
    // echo 'hello from: ' . __FILE__ . '<br>';
    
    $url = $this->getUrl();

    if(is_null($url))  $this->callDefaultAndExit();
    if(count($url) < 2) $this->callDefaultAndExit();

    $controllerPath = "../app/controllers/";
    if($url[0] == 'api') {
      $controllerPath = "../app/controllers/api/";
      array_shift($url);
      if(count($url) < 2) $this->callDefaultAndExit();
    }

    $this->currentControllerName_ = ucwords( array_shift($url) );
    if(!file_exists($controllerPath . $this->currentControllerName_ . ".php")) {
      $this->callDefaultAndExit();
    }

    require_once $controllerPath . $this->currentControllerName_ . ".php";

    $this->currentController_ = new $this->currentControllerName_;
   
    $this->currentMethod_ = array_shift($url);
    if(!method_exists($this->currentController_ , $this->currentMethod_)) {
      $this->callDefaultAndExit();
    } 
   
    $this->params_ = $url;

    //Call the method with specified parameters
    call_user_func_array([$this->currentController_, $this->currentMethod_], $this->params_);
  }

  private function getUrl() {
    if(isset($_GET['url'])) {
      $url = rtrim($_GET['url'], '/'); //remove the last '/'
      $url = filter_var($url, FILTER_SANITIZE_URL);
      //SPLIT URL INTO AN ARRAY
      $url = explode('/', $url);
      return $url;
    } else {
      return [];
    }
  }

  private function callDefaultAndExit() {
    require_once "../app/controllers/Pages.php";
    $defaultController = new Pages;
    $defaultController->index();
    die();
  }
}