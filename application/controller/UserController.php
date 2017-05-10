<?php

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        Auth::checkAuthentication();
    }

    public function index()
    {
        $this->View->render('user/index', array(
            'parties' => PartyModel::getAllParties()
        ));
    }
}