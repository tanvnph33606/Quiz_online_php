<?php

class Topic extends Controller
{
    private $topicModel;
    private $classModel;
    private $subjectModel;
    function __construct()
    {
        $this->topicModel = $this->modelAdmin('TopicModel');
        $this->subjectModel = $this->modelAdmin('SubjectModel');
        $this->classModel = $this->modelAdmin('ClassModel');
    }

    function topicController()
    {

        $delMassage = Session::get('deleteMessage');
        $delType = Session::get('deleteType');
        $dataSubject = $this->subjectModel->getAllSubject() ?? [];
        $dataClass = $this->classModel->getAllClass() ?? [];
        $dataTopic = $this->topicModel->getAllTopic() ?? [];

        $this->view('layoutServer', [
            'active' => 'topic',
            'pages' => 'topic/topic',
            'title' => 'Danh sách môn học',
            'dataSubject' => $dataSubject,
            'dataClass' => $dataClass,
            'dataTopic' => $dataTopic,

            'delMessage' => $delMassage,
            'delType' => $delType
        ]);
    }
}
