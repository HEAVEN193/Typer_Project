<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Typer++ | Sign In</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="css/register-page.css">
    <link rel="stylesheet" href="css/login-page.css">
    <!-- <link rel="stylesheet" href="css/style-home.css"> -->
    <!--Stylesheet-->

</head>
<body>
<a href="/" class="btnBack"><i class="fa fa-arrow-left" style="color: #ff4545;"></i>
    <span >Back</span></a>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="/login-attempt" method="post">
        <h3>login</h3>

        <label for="username">Email</label>
        <input type="text" placeholder="Email" id="username" name="username">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password">

        <button type="submit" name="submit">Log In</button>
        <p class="errodsars" >
        <?php
            if(isset($_SESSION['error'])){
                echo $_SESSION['error'];
                unset($_SESSION['error']); 
            } 
        ?>
        </p>

    </form>
</body>
</html>
