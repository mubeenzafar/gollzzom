<?php 
include "connection.php";
include "functions.php";
if(!isset($_SESSION['user_id']))
{
  redirect('login.php');
}


?> 

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Graphic Designer Project Management</title>
    <link rel="icon" href="">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/slider.css" rel="stylesheet">
    
  </head>
  <body>