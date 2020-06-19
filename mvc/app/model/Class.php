<?php

    class ClassStudent {
        public $name;
        public $teacherName;
        public $maxStudent;
        public function __construct($name, $teacherName, $maxStudent)
        {
            $this->name = $name;
            $this->teacherName = $teacherName;
            $this->maxStudent = $maxStudent;
        }
    }