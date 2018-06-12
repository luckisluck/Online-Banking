<?php
  session_start();
include 'employee-sidebar.php';
  ?>
  <!DOCTYPE html>
  <html>
  <title>Employee Page</title>
  <head>
  <style>
  table, th, td {
       border: 1px solid black;
  }
  </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

  <?php include 'dbconnect.php'; ?>
  <br>
  <body>
<div class="col-sm-12">
  <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
  <h1>Welcome Bitch</h1>
</div>

 <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>




  </body>
  </html>