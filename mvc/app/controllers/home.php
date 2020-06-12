<?php

class Home extends Controller
{
    public function index($name = '')
    {
       $this->model('User');
    }
}