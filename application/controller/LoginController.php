<?php

class LoginController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        if (LoginModel::isUserLoggedIn()) {
            Redirect::home();
        } else {
            $data = array('redirect' => Request::get('redirect') ? Request::get('redirect') : NULL);
            $this->View->render('login/index', $data);
        }
    }

    public function login()
    {
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            exit();
        }

        $login_successful = LoginModel::login(
            Request::post('user_name'), Request::post('user_password'), Request::post('set_remember_me_cookie')
        );

        if ($login_successful) {
            if (Request::post('redirect')) {
                Redirect::toPreviousViewedPageAfterLogin(ltrim(urldecode(Request::post('redirect')), '/'));
            } else {
                Redirect::to('user/index');
            }
        } else {
            if (Request::post('redirect')) {
                Redirect::to('login?redirect=' . ltrim(urlencode(Request::post('redirect')), '/'));
            } else {
                Redirect::to('login/index');
            }
        }
    }

    public function logout()
    {
        LoginModel::logout();
        Redirect::home();
        exit();
    }

    public function loginWithCookie()
    {
        $login_successful = LoginModel::loginWithCookie(Request::cookie('remember_me'));

        if ($login_successful) {
            Redirect::to('dashboard/index');
        } else {
            LoginModel::deleteCookie();
            Redirect::to('login/index');
        }
    }

}
