<?php

session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!isset($_SESSION['page'])) {
    $_SESSION['page'] = 'login';
}



$pageController = '';

$controllers = array();
$controllers['default'] = './pages/login/';
$controllers['login'] = './pages/login/';
$controllers['landing'] = './pages/landing/';


foreach($controllers as $cid => $contoller)
{
    $pageID = $_SESSION['page'];
    if($pageID==$cid)
    {
        $pageController = $contoller;
        include "{$pageController}controller.php";
    }
}

if($pageController=='')
{
    $pageController = $controllers['default'];
    include "{$pageController}controller.php";
}

?>
