<?php

$password = isset($_POST["password"]) ? $_POST["password"] : null;
$api = isset($_POST["api"]) ? $_POST["api"] : null;

$showLogin = true;

if($password!=null && $api!=null)
{
  if($password=="aaaaaaa")
  {
    $_SESSION['page'] = 'landing';
    $_SESSION['contentpermission'] = true;
    $showLogin = false;
  } else {
    $showLogin = true;
  }
}

if($showLogin)
{
  include __DIR__."/view.php";
}
