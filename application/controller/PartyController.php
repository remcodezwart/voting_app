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
           'party' =>  $party
        ));
    }

}
