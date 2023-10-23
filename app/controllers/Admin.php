<?php
Format::autoLoadFiles('app/controllers/admin');


class Admin extends Controller
{

    use SweetAlert;

    public function __construct()
    {
        // Authenticate::checkRoleAdmin();
    }

    function Default()
    {
        $productModel = $this->modelAdmin('ProductModel');
        $userModel = $this->modelAdmin('UserModel');
        $prodCount = $productModel->countProduct() ?? 0;
        $userCount = $userModel->countUser() ?? 0;

        $dataProdOrderBySold = $productModel->getAllProductOrderBySold() ?? [];
        $dataProdAll = $productModel->getAllProduct() ?? [];
        $dataRatingsProd = $productModel->getAllRatingsProd(4) ?? [];

        $totalRevenue = 0;
        $totalSold = 0;
        foreach ($dataProdAll as $item) {
            $totalRevenue += ($item['price'] * $item['sold']);
            $totalSold += $item['sold'];
        }

        // Services::uploadToCloudinary();
        $this->view('layoutServer', [
            'title' => 'Bảng điều khiển',
            'active' => 'dashboard',
            'pages' => 'dashboard',
            'prodCount' => $prodCount,
            'userCount' => $userCount,
            'dataProdOrderBySold' => $dataProdOrderBySold,
            'totalRevenue' => $totalRevenue,
            'totalSold' => $totalSold,
            'dataRatingsProd' => $dataRatingsProd,
        ]);
    }



    // My class action
    function myClass()
    {
        $myClass = new MyClass();
        $myClass->myClassController();
    }

    function getOneClass($id)
    {
        $classModel = $this->modelAdmin('ClassModel');
        echo $classModel->getOneClass($id);
    }
    function getAllClass()
    {
        $subjectModel = $this->modelAdmin('ClassModel');
        echo $subjectModel->getAllClassApi();
    }

    function addClass()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $classModel = $this->modelAdmin('ClassModel');
            $classModel->addNewClass();
        }
    }
    function updateClass()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $classModel = $this->modelAdmin('ClassModel');
            $classModel->updateClass();
        }
    }
    function deleteClass()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $classModel = $this->modelAdmin('ClassModel');
            $classModel->deleteClass();
        }
    }


    // End My class action



    // My subject action
    function subject()
    {
        $subject = new Subject();
        $subject->subjectController();
    }

    function getOneSubject($id)
    {
        $subjectModel = $this->modelAdmin('SubjectModel');
        echo $subjectModel->getOneSubject($id);
    }
    function getAllSubject()
    {
        $subjectModel = $this->modelAdmin('SubjectModel');
        echo $subjectModel->getAllSubjectApi();
    }

    function addSubject()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $subjectModel = $this->modelAdmin('SubjectModel');
            $subjectModel->addNewSubject();
        }
    }
    function updateSubject()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $subjectModel = $this->modelAdmin('SubjectModel');
            $subjectModel->updateSubject();
        }
    }
    function deleteSubject()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $subjectModel = $this->modelAdmin('SubjectModel');
            $subjectModel->deleteSubject();
        }
    }


    // End subject action


    // Topic action
    function topic()
    {
        $topic = new Topic();
        $topic->topicController();
    }

    function getOneTopic($id)
    {
        $topicModel = $this->modelAdmin('TopicModel');
        echo $topicModel->getOneTopic($id);
    }


    function addTopic()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $topicModel = $this->modelAdmin('TopicModel');
            $topicModel->addNewTopic();
        }
    }
    function updateTopic()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $topicModel = $this->modelAdmin('TopicModel');
            $topicModel->updateTopic();
        }
    }
    function deleteTopic()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $topicModel = $this->modelAdmin('TopicModel');
            $topicModel->deleteTopic();
        }
    }


    // End topic action



    //Questions

    function questions()
    {
        $questions = new Questions();
        $questions->questionsController();
    }

    function addQuestions()
    {

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $questionsModel = $this->modelAdmin('QuestionsModel');
            $questionsModel->addNewQuestions();
        }

        $questions = new Questions();
        $questions->addQuestionsController();
    }

    function importQuestions()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $questionsModel = $this->modelAdmin('QuestionsModel');
            $questionsModel->importNewQuestions();
        }
    }


    // End Questions

    // User action

    function user()
    {
        $user = new User();
        $user->userController();
    }

    function addUser()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->modelAdmin('UserModel');
            $userModel->addNewUser();
        }

        $user = new User();
        $user->addUserController();
    }


    function updateUser($id)
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->modelAdmin('UserModel');
            $userModel->updateUser($id);
        }

        $user = new User();
        $user->updateUserController($id);
    }

    function deleteUser()
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $userModel = $this->modelAdmin('UserModel');
            $userModel->deleteUser($id);
        } else {
            $this->Toast('error', 'Xoá thất bại.');
        }
    }
    function logout()
    {
        Session::destroy();
        header('location: /Quiz_online/account/login');
    }
    //End user action





    //report
    function getProdForCateChart()
    {
        $productModel = $this->modelAdmin('ProductModel');
        echo $productModel->getProdForCateChart() ?? [];
    }
    //report
}
