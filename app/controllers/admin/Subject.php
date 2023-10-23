<?php

class Subject extends Controller
{
    private $subjectModel;
    private $classModel;
    function __construct()
    {
        $this->subjectModel = $this->modelAdmin('SubjectModel');
        $this->classModel = $this->modelAdmin('ClassModel');
    }

    function subjectController()
    {

        $delMassage = Session::get('deleteMessage');
        $delType = Session::get('deleteType');
        $dataSubject = $this->subjectModel->getAllSubject() ?? [];
        $dataClass = $this->classModel->getAllClass() ?? [];

        $this->view('layoutServer', [
            'active' => 'subject',
            'pages' => 'subject/subject',
            'title' => 'Danh sách môn học',
            'dataSubject' => $dataSubject,
            'dataClass' => $dataClass,


            'delMessage' => $delMassage,
            'delType' => $delType
        ]);
    }
}
