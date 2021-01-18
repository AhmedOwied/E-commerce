<?php 
    session_start(); 
    $pageTitle='Dashboard';
    if(isset($_SESSION['Username'])){
        
       include 'init.php';
     
       print_r($_SESSION); 

       include $tmp.'Footer.php';
    }

    else{
        echo 'You Are not view this page';
        header('location:index.php');
        exit();
    }