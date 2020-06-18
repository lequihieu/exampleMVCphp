<?php

require_once '../app/core/db.php';

class Home extends Controller
{
    const servername = "localhost";
    const username= "root";
    const password= "Ridaica123~";


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
        
        $dbname = "studentdb";
        $conn = new mysqli(self::servername, self::username, self::password, $dbname);

        if(!empty($_POST))  
        {  
           
            $name = mysqli_real_escape_string($conn, $_POST["name"]);  
            $age = mysqli_real_escape_string($conn, $_POST["age"]);  
            $email = mysqli_real_escape_string($conn, $_POST["email"]);  
            $class = mysqli_real_escape_string($conn, $_POST["class"]);  
                
            if($_POST["student_id"] !== '')  
            {  
                $id = $_POST["student_id"];
                
                $query = "  
                UPDATE student   
                SET name='$name',   
                age='$age',   
                email='$email',   
                class = '$class'   
                WHERE id=$id";  
                $message = 'Data Updated'; 
            }  
            else  
            {  
                $query = "  
                INSERT INTO student(name, age, email, class)  
                VALUES('$name', '$age', '$email', '$class');  
                ";  
                $message = 'Data Inserted';  
            } 
        } 
        // if ($conn->connect_error) {
        //     die("Connection failed: " . $conn->connect_error);
        // }
        
        // $name = $_POST['name'];
        // $age = $_POST['age'];
        // $email = $_POST['email'];
        // $class = $_POST['class'];
        
        // $sql = 'INSERT INTO student(name, age, email, class) VALUE('."'".$name."',"."'".$age."','".$email."','".$class."')";
       
        $result = mysqli_query($conn, $query);

     
        echo $message;
    }

    public function getAllList() {
        $dbname = "studentdb";
        $servername = self::servername;
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", self::username, self::password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM student");
        $stmt->execute();
      
        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        
    }

    public function deleteStudent() {

        $dbname = "studentdb";
        $conn = new mysqli(self::servername, self::username, self::password, $dbname);

        $id = $_POST['student_id'];

        $sql = 'DELETE FROM student WHERE id ='. $id;
        $result = mysqli_query($conn, $sql);
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
       
        $dbname = "studentdb";
        $conn = new PDO("mysql:host=$this->servername;dbname=$dbname", self::username, self::password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $text_search = $_POST['text_search'];
        $stmt = $conn->prepare('SELECT * from student where CONCAT_WS('. "''" . ', name, age, email, class) LIKE ' . "'" . "%$text_search%" . "'");
        $stmt->execute();
      
        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    }
}