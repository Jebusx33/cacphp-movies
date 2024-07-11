<?php 
session_start();
include '../config/database.php';

if ($_SERVER['REQUEST_METHOD']= "GET") {
   
    $modo = $_GET['modo'];
   
    if ($modo==='todas') {
        header('Location: usuario.php?modo=todas');
    } else{
        header('Location: usuario.php?modo=genero');

    }
}    
   




