<?php

class StatementController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        Auth::checkAuthentication();
    }

    public function index()
    {
        $this->View->render('statement/index', array(
            'statments' => StatementModel::getAllstatements()
        ));
    }

    public function add()
    {
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            exit();
        }


        StatementModel::addStatement(request::post('statement'));
        redirect::to("statement/index");
    }

    public function edit()
    {
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            exit();
        }

        StatementModel::editStatement(request::post('id'), request::post('statement'), request::post('delete'));
        redirect::to("statement/index");
    }
}