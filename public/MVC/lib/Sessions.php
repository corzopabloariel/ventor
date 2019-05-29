<?php
class Session {
    static function createSession(){
        @session_start();
    }
    static function logUser($user) {
        $_SESSION['user'] = $user;
    }
    static function relogUser($user) {
        $_SESSION['user'] = $user;
    }
    static function isLogged() {
        if(isset($_SESSION['user'])) {
            return true;
        } else {
            if(isset($_COOKIE['authToken'])) {
                list($selector, $token) = explode(':', $_COOKIE['authToken']);
                $data = Logins::findOneBy($selector,"login_selector");
                if($data) {
                    if(hash_equals($data->_GET('login_token'), hash('sha256', base64_decode($token)))) {
                        $timestamp = time();
                        if($data->_GET("login_expires") <= $timestamp)
                            Session::relogUser($data->_GET('id_user'));
                        else
                            Session::logOut();
                    } else {
                        Session::logOut();
                        return false;
                    }
                } else
                    return false;
            } else
                return false;
        }
    }

    static function logOut() {
        unset($_SESSION['user']);
        setcookie('authToken', '', 1);
        unset($_COOKIE['authToken']);
    }

    static function getId(){
        return $_SESSION['user'];
    }
}
