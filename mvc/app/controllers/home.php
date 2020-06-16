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
        $servername = "localhost";
        $username = "root";
        $password = "Ridaica123";
        $dbname = "studentdb";
        $conn = new mysqli($servername, $username, $password, $dbname);


        //header('Content-type: text/javascript');
        // $json = array(
        //     'name' => '',
        //     'age'  => '',
        //     'email' => '',
        //     'class' => '',
        //     'success' => false
        // );

        //     $json['name'] = $_POST['name'];
        //     $json['age'] = $_POST['age'];
        //     $json['email'] = $_POST['email'];
        //     $json['class'] = $_POST['class'];
        //     $json['success'] = true;
       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $class = $_POST['class'];
        
        $sql = 'INSERT INTO student(name, age, email, class) VALUE('."'".$name."',"."'".$age."','".$email."','".$class."')";
       
        $result = mysqli_query($conn, $sql);


        echo $result;
    }

    public function getAllList() {

        $servername = "localhost";
        $username = "root";
        $password = "Ridaica123";
        $dbname = "studentdb";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM student");
        $stmt->execute();
      
        // set the resulting array to associative
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
        
    }

    public function deleteStudent() {

    }

    public function UpdateStudent() {
      
    }
}