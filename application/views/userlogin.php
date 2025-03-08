<!DOCTYPE html>
<html>

<head>
  <title>PROGRESSIVE CHILDREN ACADEMY | <?php echo $title; ?></title>
  <link rel="icon" href="<?php echo base_url(); ?>assets/login/images/logo.png">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/login/css/style.css">

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <style>
    html {
      background-color: rgb(213, 231, 55);

    }

    body {
      background-image: url("assets/images/bg.png");
    }
  </style>
</head>
<!------ Include the above in your HEAD tag ---------->

<body>
  <div class="wrapper fadeInDown">
    <img src="<?php echo base_url(); ?>assets/images/banner.png" />

    <!--<h6 style="text-align:center;font-family:roman;">SCHOOL MANAGEMENT SYSTEM</h6>-->
    <div id="formContent">
      <!-- Tabs Titles -->

      <!-- Icon -->
      <div class="fadeIn first">
        <img src="<?php echo base_url(); ?>assets/login/images/favicon.png" id="icon" alt="User Icon" style="width:100px;height:100px;border:1px solid black;border-radius:50px;" />
      </div>

      <!-- Login Form -->
      <form method="post" action="<?php echo site_url('users/login') ?>" id="loginForm">
        <input type="text" id="username" name="username" class="fadeIn second" placeholder="login" Autocomplete="off">
        <input type="password" id="password" name="password" class="fadeIn third" placeholder="password">
        <input type="submit" class="fadeIn fourth">
      </form>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        <a class="underlineHover" href="<?php echo base_url(); ?>" style="text-decoration:none;">SCHOOL MANAGEMENT SYSTEM</a>
      </div>

    </div>
    <br><br>
    <p>Powered By <a href="http://inlancers.com/" style="text-decoration:none;background:white;border-radius:5px;padding:5px;" target="_blank">Inlancers Technology</a></p>
  </div>

  <script type="text/javascript" src="<?php echo base_url('custom/js/login.js') ?>"></script>
</body>

</html>