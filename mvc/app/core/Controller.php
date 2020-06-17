<?php

class Controller
{
    public function model($model) 
    {
        require_once '../app/model/' .$model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        require_once '../app/views/'. $view .'.php';
    }

    public function viewAddStudent()
    {
        require_once '../app/views/home/formStudent.html';
        
    }

    public function addStudent() 
    {
        
    }
}