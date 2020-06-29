<?php
require_once '../app/model/Student.php';
require_once '../app/model/Class.php';
    class Mysql {
        static $servername = "localhost";
        static $username = "root";
        static $password = "Ridaica123";
        static $dbname = "studentdb";
        
        private static $conn;
      
        public function __construct()
        {
            $this->connectDB();

        }

        private function connectDB() {
            $dbname = self::$dbname;
            $servername = self::$servername;
            self::$conn = new PDO("mysql:host=$servername;dbname=$dbname", self::$username, self::$password);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function getRowById($id, $table) 
        {   
        
            $query = "SELECT * FROM $table WHERE id = $id";
            
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
      
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
           
            return $result;
        }

        public function deleteRowById($id, $table)
        {
            $query = "DELETE FROM $table WHERE id = $id";  
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
        }

        public function updateStudentById($id, $student, $table) 
        {
           
            $name = $student->name;
            $age = $student->age;
            $email = $student->email;
            
            $query = "  
            UPDATE $table   
            SET name='$name',   
            age='$age',   
            email='$email'  
            WHERE id=$id";  

            $stmt = self::$conn->prepare($query);
            $stmt->execute();
        }

        public function insertStudent($student, $table) 
        {   
    
            $name = $student->name;
            $age = $student->age;
            $email = $student->email;
            $query = "  
            INSERT INTO $table(name, age, email)  
            VALUES('$name', '$age', '$email');  
            "; 

            $stmt = self::$conn->prepare($query);
            $stmt->execute();

        }

        public function getAllRow($table) 
        {
            
            $stmt = self::$conn->prepare("SELECT * FROM $table");
            $stmt->execute();
      
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getListByText($text, $table)
        {    
            $query = "SELECT * FROM $table WHERE CONCAT_WS('', name, age, email) LIKE '%$text%' ";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function insertClass($class, $table)
        {
            $name_class = $class->name;
            $teacher_name = $class->teacherName;
            $max_student = $class->maxStudent;
            
            $query = "  
            INSERT INTO $table(name, teacher_name, max_student)  
            VALUES('$name_class', '$teacher_name', '$max_student');  
            "; 

            $stmt = self::$conn->prepare($query);
            $stmt->execute();
        }

        public function getIdRowFromName($name, $table) {
           
            $query = "SELECT `id` FROM $table WHERE `name` = '$name'";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
           
            return $result["id"];
        }

        public function insertStudentIntoClass($studentId, $classId, $table) {
          
            $query = "
            INSERT INTO $table(class_id, student_id)
            VALUES('$classId', '$studentId');
            ";

            $stmt = self::$conn->prepare($query);
            $stmt->execute();
        }

        public function getAllClassById($class_table, $class_student_table, $studentId) 
        {
            $stmt = self::$conn->prepare("
            SELECT * FROM $class_table 
            WHERE id IN 
            (SELECT c.class_id FROM $class_student_table c WHERE c.student_id = $studentId)");
            $stmt->execute();
        
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getUserByPass($table, $username, $password) 
        {
            $query = "SELECT * FROM $table WHERE username = '$username' and password = '$password'";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return json_encode($result);
        }

        public function insertQuestion($content_question, $answer_question, $content_answer){

            $query = "  
            INSERT INTO question(content_question, answer_question)  
            VALUES('$content_question', '$answer_question');  
            "; 
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
            $last_id = self::$conn->lastInsertId();

            var_dump($content_answer);

            foreach($content_answer as $key => $val) {
                $query = "  
                INSERT INTO content_answer(question_id, content, answer)  
                VALUES($last_id, '$val', $key);  
                "; 

                $stmt = self::$conn->prepare($query);
                $stmt->execute();

            }
        }

        public function insertExamination($name, $teacher_id, $list_question) 
        {
            $query = "  
            INSERT INTO examination(name, teacher_id)  
            VALUES('$name', $teacher_id);  
            "; 

            $stmt = self::$conn->prepare($query);
            $stmt->execute();

            $last_id = self::$conn->lastInsertId();

            foreach($list_question as $question_id) {
                $query = "  
                INSERT INTO exam_question(examination_id, question_id)  
                VALUES($last_id, $question_id);  
                "; 
                $stmt = self::$conn->prepare($query);
                $stmt->execute();
            }
        }

        public function getAnswerContent($question_id)
        {
            $stmt = self::$conn->prepare("SELECT content, answer FROM content_answer WHERE question_id = $question_id");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function getQuestion($id) {
            
            $table = "question";
            $question_content = $this->getRowById($id, $table);
            $answer_content = $this->getAnswerContent($id);
            $question_content['answer_content'] = $answer_content;
            return $question_content;
        }
        
        public function getListQuestionById($examination_id) {
            $query = "
            SELECT question_id FROM exam_question WHERE examination_id = $examination_id";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function insertExaminationIntoStudent($examination_id, $student_id) {
            $query = "
            INSERT INTO student_exam(student_id, exam_id)
            VALUES($student_id, $examination_id)";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
        }

        public function getListExamByStudentId($student_id) {
            $query = "
            SELECT * FROM examination WHERE id IN
            (SELECT exam_id FROM student_exam WHERE student_id = $student_id)
            ";
            $stmt = self::$conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
