<?php

require_once '../app/core/db.php';
require_once '../app/model/Student.php';
require_once '../app/model/Class.php';
class Home extends Controller
{
   
    // public function index($name = '')
    // {   
    //     $user = $this->model('User');
    //     $user->name = $name;
        
    //     //$this->view('home/index', ['name' => $user->name]);
       
    // }
    /**
     * Class constructor.
     */
    
    public function addStudentForm() {
        $this->viewAddStudent();
    }

    public function loginForm() {
        $this->viewFormLogin();
    }

    public function testStudent() {
        $this->viewTestStudent();
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
        echo json_encode($result);
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
        $classId = $mysql->getIdRowFromName($name_class, $tableClass);
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

    public function loginUser() {
        $mysql = new Mysql();
        $table = "student";
        $username = $_POST['username'];
        $password = $_POST['password'];
        $result = $mysql->getUserByPass($table, $username, $password);
        echo $result;
    }

    public function addQuestion() {
        $mysql = new Mysql();
        $content_question = $_POST['content_question'];
        $answer_question = $_POST['answer_question'];
        $content_answer = $_POST['content_answer'];
        $result = $mysql->insertQuestion($content_question, $answer_question, $content_answer);
        echo $result;
    }

    public function addExamination() {
        $mysql = new Mysql();
        $name = $_POST['name'];
        $teacher_id = $_POST['teacher_id'];
        $list_question = $_POST['list_question'];
        $result = $mysql->insertExamination($name, $teacher_id, $list_question);
        echo $result;
    }

    public function getExamination() {
        $mysql = new Mysql();
        $id = $_POST['id'];
        $table = "examination";
        $examination = $mysql->getRowById($id, $table);
        $list_question = $mysql->getListQuestionById($id);
        //var_dump($list_question);

        foreach($list_question as $key => $question) {
            $question_id = $question['question_id'];
            $res[$key] = $mysql->getQuestion($question_id);
        }
       // $res['info'] = $examination;
        echo json_encode($res);
    }

    public function getListQuestion() {
        $mysql = new Mysql();
        $id = $_POST['id'];
        $list_question = $mysql->getListQuestionById($id);
        
        echo json_encode($list_question);
    }

    public function getListExamById() {
        $mysql = new Mysql();
        $student_id = $_POST['student_id'];
        $list_exam = $mysql->getListExamByStudentId($student_id);
        echo json_encode($list_exam);
    }
    public function calculatorExam() {
        $mysql = new Mysql();
        $examination_id = $_POST['id'];
        $answer_question_of_student = $_POST['answer_of_student'];
        $score = 0;
        $list_question = $mysql->getListQuestionById($examination_id);
      
        foreach($list_question as $question) {
            $question_id = $question["question_id"];
            $question_content = $mysql->getRowById($question_id, "question");
            $question_id = intval($question_id);

            if($answer_question_of_student[$question_id]===$question_content['answer_question']) $score++; 
        }
        
        echo $score;
        
    }

    public function addExaminationIntoStudent() {
        $mysql = new Mysql();
        $table = "examination";
        $name_exam = $_POST['name_exam_add'];
        $student_id = $_POST['student_id'];
        $examination_id = $mysql->getIdRowFromName($name_exam, $table);
        $result = $mysql->insertExaminationIntoStudent($examination_id, $student_id);
    }
}