<?php

    class Mysql {
        const servername = "localhost";
        const username = "root";
        const password = "Ridaica123~";
        const dbname = "studentdb";
        
        //private $conn;
      
        public function __construct()
        {
            
        }
        private function connectDB() {

            //self::$conn = new mysqli(self::servername, self::username, self::password, self::dbname);

        }
        public function getRowById($id, $table) 
        {   
            $conn = new mysqli(self::servername, self::username, self::password, self::dbname);
            $query = "SELECT * FROM $table WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            return json_encode($row);
        }

        private function deleteRowById($id, $table)
        {

        }

        private function updateInfoById($student, $table) 
        {

        }

        private function insertInfo($student, $table) 
        {

        }

        private function getAllRow($table) 
        {
        }

        private function getInfoByText($text, $table)
        {

        }
    }
