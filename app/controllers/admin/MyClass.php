<?php

class MyClass extends Controller
{
    private $classModel;
    function __construct()
    {
        $this->classModel = $this->modelAdmin('ClassModel');
    }

    function myClassController()
    {

        $delMassage = Session::get('deleteMessage');
        $delType = Session::get('deleteType');
        $dataClass = $this->classModel->getAllClass() ?? [];

        $this->view('layoutServer', [
            'active' => 'class',
            'pages' => 'myClass/myClass',
            'title' => 'Danh sách lớp học',
            'dataClass' => $dataClass,


            'delMessage' => $delMassage,
            'delType' => $delType
        ]);
    }
}
