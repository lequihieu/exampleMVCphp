<?php

require_once '../app/core/db.php';
require_once '../app/model/Student.php';
require_once '../app/model/Class.php';
class Home extends Controller
{
    const servername = "localhost";
    const username= "root";
    const password= "Ridaica123";


    public function index($name = '')
    {   
        $user = $this->model('User');
        $user->name = $name;
        
        //$this->view('home/index', ['name' => $user->name]);
       
    }
    public function addStudentForm() {
        $this->viewAddStudent();
    }

    public function addStudent() {
        
        $mysql = new Mysql();
        $table = "student";

        if(!empty($_POST))  
        {             
            $name = $_POST["name"];
            $age = $_POST["age"];
            $email = $_POST["email"];
          
            $student = new Student($name, $age, $email);

            if($_POST["student_id"] !== '')  
            {  
                $id = $_POST["student_id"];
                $mysql->updateStudentById($id, $student, $table);             
                $message = 'Data Updated'; 
            }  
            else  
            {  
                $mysql->insertStudent($student, $table);               
                $message = 'Data Inserted';  
            } 
        }     
        echo $message;
    }

    public function getAllList() {
        
        $table = "student";
        $mysql = new Mysql();
        $result = $mysql->getAllRow($table);
        echo json_encode($result);
    }

    public function deleteStudent() {

      
        $id = $_POST['student_id'];
        $table = "student";
        $mysql = new Mysql();
        $result = $mysql->deleteRowById($id, $table);
        echo $result;
    }

    public function getStudent() {
    
        $id = $_POST['student_id'];
        $table = "student";
        $mysql = new Mysql();
        $result = $mysql->getRowById($id, $table);
        echo $result;
    }

    public function searchStudent() {
      
        $text_search = $_POST['text_search'];
        $mysql = new Mysql();
        $table = "student";
        $result = $mysql->getListByText($text_search, $table);
        echo json_encode($result);
    }

    public function addClass() {

        $name_class = $_POST['name_class'];
        $teacher_name = $_POST['teacher_name'];
        $max_student = $_POST['max_student'];

        $class = new ClassStudent($name_class, $teacher_name, $max_student);
        $mysql = new Mysql();
        $table = "class";
        $result = $mysql->insertClass($class, $table);
        echo $name_class;
    }

    public function getAllClass() 
    {
        $mysql = new Mysql();
        $table = "class";
        $result = $mysql->getAllRow($table);
        echo json_encode($result);
    }

    public function addStudentIntoClass() {
        $mysql = new Mysql();
        $tableStudentClass = "class_student";
        $tableClass = "class";
        $studentId = $_POST['student_class_id'];
        $name_class = $_POST['name_class_add'];
        $classId = $mysql->getIdClassFromName($name_class, $tableClass);
        $result = $mysql->insertStudentIntoClass($studentId, $classId, $tableStudentClass);
        echo $result;
    }

    public function getAllClassByStudentId() {
        $mysql = new Mysql();
        $table = "class";
        $tableStudentClass = "class_student";
        $studentId = $_POST['student_id'];
        $result = $mysql->getAllClassById($table, $tableStudentClass, $studentId);
        echo json_encode($result);
    }
}