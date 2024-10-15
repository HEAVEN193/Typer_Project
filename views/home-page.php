<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style-home.css">
    <link rel="icon" href="/resources/icon/icon_typerPP_TEXT.png" type="image/gif">
    <title>Projet Typer | home</title>
    <script src="https://kit.fontawesome.com/7c6bb8aaf1.js" crossorigin="anonymous"></script>
</head>
<body>
    <header id="PageHeader">
        <div>
            <div id="divLogo">
                <a href="/"><img id="logo" src="/resources/icon/icon_typerPP.png"></img></a>
                <h1>TYPER<span class="red">++</span></h1>
            </div>
        </div>
        <div>
            <div id="optionsUserInf">
                <!-- <div id="divOptions"> -->
                
                    <div id="CapsLock">
                        <i id="logoCadena"class="fa fa-lock-open" style="margin: 2px 7px;"></i>
                        <p>Caps Lock</p>
                    </div>
                    <button id="btnOptions" class="btn">OPTIONS</button>
                <!-- </div>  -->
                <div id="UserInf">
                    <div id="divPseudo">
                        <?php
                        use Matteomcr\TyperProject\Models\Utilisateur;

                        if(Utilisateur::current())
                            echo Utilisateur::current()->pseudo; 
                        else
                            echo "LOGIN";
                        ?>
                    </div>
                    <a href="
                    <?php
                    if(Utilisateur::current())
                        echo "/user"; 
                    else
                        echo "/login";
                    ?>
                    ">
                        <div id="user_pp_container">
                            <i class="fa fa-user" aria-hidden="true"></i>
    
                        </div>
                    </a>
                    
                </div>
            </div>
        </div>
    </header>
    <main id="main">
        <div class="header">
            <div class="info">30</div>
            <div class="buttons">
                <button class="btnReplay">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <div class="game">
            <div class="words" tabindex="1"></div>        
            <div class="cursor"></div>
        </div>
    </main>

    <footer>
        <div class="timer-choice-container">
                
            <!-- </label for="time">Temps du test :  </label> -->
                <select id="time" name="time">
                    <option value="15">15 secondes</option>
                    <option value="30">30 secondes</option>
                    <option value="45">45 secondes</option>
                    <option value="60">60 secondes</option>
                </select>
        </div>

                
            <!-- </label for="time">Temps du test :  </label> -->
        <div class="language-choice-container">
            
            <!-- </label for="time">Temps du test :  </label> -->
            <select id="language">
                <option value="Français">Français</option>
                <option value="Anglais">English</option>
                <option value="Espagnol">Español</option>
            </select>
        </div>  
    </footer>
    <!-- <form id="carForm" method="POST">
    <label for="car-select">durée de test :</label>
        <select id="car-select" name="car">
            <option value="15">15 secondes</option>
            <option value="30">30 secondes</option>
            <option value="45">45 secondes</option>
            <option value="60">60 secondes</option>
        </select>
    </form> -->

    <div id="OptionsPopUp">
        <div id="OptBtnsSpace">
            
            <?php
            // Si utilisateur pas connecté

            if(!Utilisateur::current()){
                echo '<a href="/login"><button class="btn" id="btnLogin">Se Connecter</button></a>
                <a href="/register"><button class="btn" id="btnCreateAccount">Creer un compte</button></a>';
            }else{
                echo '<a href="/user"><button class="btn" id="btnUserSettings">Parametres Typer</button></a>
                 <a href="/logout"><button class="btn" id="btnUserLogout">Se déconnecter</button></a>';
            }
            
            ?>  
            <button class="btn" id="btnThemes">Themes</button>
            <button class="btn" id="btnForLater">à faire</button> 
            <a href="/"><button class="btn" id="btnBack">Retour</button></a>
        </div>
    </div>
</body>
<script src="/js/script-home.js"></script>
</html>