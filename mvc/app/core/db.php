<?php
require_once '../app/model/Student.php';
require_once '../app/model/Class.php';
    class Mysql {
        const servername = "localhost";
        const username = "root";
        const password = "Ridaica123";
        const dbname = "studentdb";
        
        private $conn;
      
        public function __construct()
        {
            //$this->connectDB();
        }

        private function connectDB() {
            self::$conn = new mysqli(self::servername, self::username, self::password, self::dbname);
        }
        public function getRowById($id, $table) 
        {   
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $query = "SELECT * FROM $table WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            return json_encode($row);
        }

        public function deleteRowById($id, $table)
        {
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $query = "DELETE FROM $table WHERE id = $id";
            $result = mysqli_query($conn, $query);
            return $result;
        }

        public function updateStudentById($id, $student, $table) 
        {
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $name = mysqli_real_escape_string($conn, $student->name);
            $age = mysqli_real_escape_string($conn,$student->age);
            $email = mysqli_real_escape_string($conn,$student->email);
        
            $query = "  
            UPDATE $table   
            SET name='$name',   
            age='$age',   
            email='$email'  
            WHERE id=$id";  

            $result = mysqli_query($conn, $query);
            return $result;
        }

        public function insertStudent($student, $table) 
        {   
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $name = mysqli_real_escape_string($conn, $student->name);
            $age = mysqli_real_escape_string($conn,$student->age);
            $email = mysqli_real_escape_string($conn,$student->email);
            
            $query = "  
            INSERT INTO $table(name, age, email)  
            VALUES('$name', '$age', '$email');  
            "; 
            $result = mysqli_query($conn, $query);
        }

        public function getAllRow($table) 
        {
            $dbname = self::dbname;
            $servername = self::servername;
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", self::username, self::password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM $table");
            $stmt->execute();
      
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getListByText($text, $table)
        {
            $dbname = self::dbname;
            $servername = self::servername;
            $conn = new PDO("mysql:host=$this->servername;dbname=$dbname", self::username, self::password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $conn->prepare("SELECT * FROM $table WHERE CONCAT_WS('', name, age, email) LIKE '%$text%' ");
            $stmt->execute();
        
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function insertClass($class, $table)
        {
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $name_class = mysqli_real_escape_string($conn, $class->name);
            $teacher_name = mysqli_real_escape_string($conn, $class->teacherName);
            $max_student = mysqli_real_escape_string($conn, $class->maxStudent);
            
            $query = "  
            INSERT INTO $table(name, teacher_name, max_student)  
            VALUES('$name_class', '$teacher_name', '$max_student');  
            "; 
            $result = mysqli_query($conn, $query);
        }

        public function getIdClassFromName($name_class, $table) {
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $name_class = mysqli_real_escape_string($conn, $name_class);

            $query = "SELECT `id` FROM $table WHERE `name` = '$name_class'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            return $row['id'];
        }

        public function insertStudentIntoClass($studentId, $classId, $table) {
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);

            $query = "
            INSERT INTO $table(class_id, student_id)
            VALUES('$classId', '$studentId');
            ";

            $result = mysqli_query($conn, $query);
            return $result;
        }

        public function getAllClassById($class_table, $class_student_table, $studentId) {

            $dbname = self::dbname;
            $servername = self::servername;
            $conn = new PDO("mysql:host=$this->servername;dbname=$dbname", self::username, self::password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("
            SELECT * FROM $class_table 
            WHERE id IN 
            (SELECT c.class_id FROM $class_student_table c WHERE c.student_id = $studentId)");
            $stmt->execute();
        
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getUserByPass($table, $username, $password) {
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $query = "SELECT * FROM $table WHERE username = '$username' and password = '$password'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            return json_encode($row);
        }

        public function insertQuestion($content_question, $answer_question, $content_answer){
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $query = "  
            INSERT INTO question(content_question, answer_question)  
            VALUES('$content_question', '$answer_question');  
            "; 
            $result = mysqli_query($conn, $query);
            $last_id = mysqli_insert_id($conn);
            var_dump($content_answer);
            foreach($content_answer as $key => $val) {
                $query = "  
                INSERT INTO content_answer(question_id, content, answer)  
                VALUES($last_id, '$val', $key);  
                "; 
                $result = mysqli_query($conn, $query);
                var_dump($result);
                var_dump($query);
            }
        }
    }
