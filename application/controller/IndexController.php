<?php

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->View->render('index/index', array(
        	'statements' => StatementModel::getAllstatements(),
            'parties' => PartyModel::getAllpartiesWithStatments()
        ));
    }

    public function answer()
    {
        if (!Csrf::isTokenValid()) {
            //no need to logout or redirect since the user is not logged in or not on the home page
            exit();
        }

        AnswerModel::answerIp();
    }
}
