<?php


class Home extends Controller
{
    public function index($name = '')
    {   
        $user = $this->model('User');
        $user->name = $name;
        
        //$this->view('home/index', ['name' => $user->name]);
       
    }

    public function test() {
        echo 'test';
    }

    public function addStudentForm() {
        $this->viewAddStudent();
    }

    public function addStudent() {
        header('Content-type: text/javascript');
        $json = array(
            'name' => '',
            'age'  => '',
            'email' => '',
            'class' => '',
            'success' => false
        );

            $json['name'] = $_POST['name'];
            $json['age'] = $_POST['age'];
            $json['email'] = $_POST['email'];
            $json['class'] = $_POST['class'];
            $json['success'] = true;
        
        echo "abc";
    }
}