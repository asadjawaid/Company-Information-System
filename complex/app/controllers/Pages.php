<?php
// the main page
class Pages extends Controller {
    public function __construct() {
        //$this->userModel = $this->model('User');
    }

  	// https://jawaid11.myweb.cs.uwindsor.ca/complex/
    public function index() {
        $data = [
            'title' => 'Home page'
        ];

        $this->view('pages/index'); // the view is index.php
    }
}