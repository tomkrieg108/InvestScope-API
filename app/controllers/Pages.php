<?php

class Pages extends Controller {

  private $pagesModel;

  public function __construct() {
    echo 'hello from: ' . __FILE__ . '<br>' ;
    $pagesModel = $this->model('Page');
  }
  
  public function index() {
    echo 'Pages->Index() called <br>';

    $data = [
      'title' => 'HOME PAGE!'
    ];

    $this->view('pages/index', $data);
  }

  public function about() {
    $data = [
      'title' => 'ABOUT PAGE'
    ];

    $this->view('pages/about', $data); 
  }
  
 }