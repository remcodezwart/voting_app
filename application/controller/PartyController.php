<?php

class PartyController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        Auth::checkAuthentication();
    }

    public function index()
    {
        $party = PartyModel::getPartyByName( Request::get('party') );

        if ( empty($party) ) {
            Redirect::to("user/index");
            exit;
        } 
        
        $this->View->render('party/index', array(
           'party' =>  $party,
           'statements' => StatementModel::getStatmentsByParty($party)
        ));
    }

    public function delete()
    {
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            exit();
        }

        PartyModel::delete(request::post('id'));
        redirect::to('user/index');
    }

    public function edit()
    {
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            exit();
        }

        PartyModel::edit(request::post('id'));
        redirect::to('party/index?party='.request::post('name'));
    }

    public function add()
    {
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            exit();
        }

        PartyModel::add(request::post('party'));
        redirect::to('user/index');
    }
}
