<?php
    //Load the model and the view
    class Controller {
      	// to load a specfic model e.g Employee.php from models folder
        public function model($model) {
            //Require model file
            require_once '../app/models/' . $model . '.php'; // ../app/models/Employee.php
            //Instantiate model
            return new $model(); // for example instantiate Employee.php inside models
        }

        //Load the view (checks for the file) for example $view = 'index'
        public function view($view, $data = [], $second_data = [], $third_data = []) {
          	// check if the file exists
            if (file_exists('../app/templates/' . $view . '.php')) {
                require_once '../app/templates/' . $view . '.php';
            } else {
                die("View does not exists.");
            }
        }
    }