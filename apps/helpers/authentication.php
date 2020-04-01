<?php 

class authentication{

    function isLogin(){
       return isset($_SESSION['login']);
    }
}