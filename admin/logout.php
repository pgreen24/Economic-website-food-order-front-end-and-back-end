<?php

//include constants php for SITEURL
include('../config/constants.php');

//1. destory the session
session_destroy();//unset $_SESSION['user']

//2. Redirect to Login page
header('location:'.SITEURL.'admin/login.php');


?>