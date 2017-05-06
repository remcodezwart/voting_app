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
        $parties = PartyModel::getAllParties(); 

        $this->View->render('user/index', array(
            'parties' => $parties
        ));
    }

}
