<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Typer++ | Sign Up</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">    <link rel="stylesheet" href="css/register-page.css">
    <script src="https://kit.fontawesome.com/7c6bb8aaf1.js" crossorigin="anonymous"></script>

    <!--Stylesheet-->

</head>
<body>
    <a href="/" class="btnBack"><i class="fa fa-arrow-left" style="color: #ff4545;"></i>
    <span >Back</span></a>
    <form action="/create-account" method="post">
        <h3>Crée un compte</h3>

        <label for="username">Nom d'utilisateur</label>
        <input type="text" placeholder="Nom d'utilisateur" id="username" name="username">

        <label for="username">Email</label>
        <input type="text" placeholder="Email" id="email" name="email">

        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Mot de passe" id="password" name="password">
        <label for="password">Confirmer mot de passe</label>
        <input type="password" placeholder="Mot de passe" id="password_confirm" name="passwordConfirm">

        <button type="submit" name="submit">Crée un compte</button>
        <p class="error" >
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
