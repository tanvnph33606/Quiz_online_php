<?php
class Questions extends Controller
{
    private $questionsModel;
    private $topicModel;
    function __construct()
    {
        $this->questionsModel = $this->modelAdmin('QuestionsModel');
        $this->topicModel = $this->modelAdmin('TopicModel');
    }

    function questionsController()
    {
        $delMessage = Session::get('deleteMessage');
        $delType = Session::get('deleteType');

        $dataQuestions = $this->questionsModel->getAllQuestions() ?? [];
        $dataTopic = $this->topicModel->getAllTopic();



        $this->view('layoutServer', [
            'title' => 'Danh sách câu hỏi',
            'active' => 'questions',
            'pages' => 'questions/questions',
            'dataQuestions' => $dataQuestions,
            'dataTopic' => $dataTopic,

            'delMessage' => $delMessage,
            'delType' => $delType,
        ]);
    }

    function addQuestionsController()
    {
        $dataTopic = $this->topicModel->getAllTopic();
        $this->view('layoutServer', [
            'title' => 'Thêm câu hỏi',
            'active' => 'questions',
            'pages' => 'questions/addQuestions',
            'dataTopic' => $dataTopic,
        ]);
    }

    function updateQuestionsController($id)
    {
        $dataUserUp = $this->questionsModel->getOneUser($id) ?? [];

        $this->view('layoutServer', [
            'title' => 'Cập nhập câu hỏi',
            'active' => 'questions',
            'pages' => 'questions/updateQuestions',
            'dataUserUp' => $dataUserUp
        ]);
    }

    function deleteQuestionsController($id)
    {
        $this->questionsModel->deleteUser($id);
    }
}
