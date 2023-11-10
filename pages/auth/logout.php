<?php 
use portal\modules\Auth;

$auth = Auth::getInstance();

$auth->logout();

if(!$auth->checkAuth()){header('Location: /');}

?>