<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Design by foolishdeveloper.com -->
    <title>Typer++ | Sign Up</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sign-up-page.css">
    <!--Stylesheet-->

</head>
<body>
    <form action="Php/traitement_SignIn.php" method="post">
        <h3>Register</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="username" id="username" name="username">

        <label for="username">Email</label>
        <input type="text" placeholder="Email" id="email" name="email">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password">
        <label for="password">Re-enter Password</label>
        <input type="password" placeholder="Password" id="password_confirm" name="passwordConfirm">

        <button type="submit" name="submit">Create account</button>
    </form>
</body>
</html>
