<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style-home.css">
    <link rel="icon" href="resources/icon/icon_typerPP_TEXT.png" type="image/gif">
    <title>Projet Typer | home</title>
    <script src="https://kit.fontawesome.com/7c6bb8aaf1.js" crossorigin="anonymous"></script>
</head>
<body>
    <header id="PageHeader">
        <div>
            <div id="divLogo">
                <img id="logo" src="resources/icon/icon_typerPP.png"></img>
                <h1>TYPER++</h1>
            </div>
        </div>
        <div>
            <div id="optionsUserInf">
                <div id="divOptions">
                    <div><p id="CapsLock">Caps Lock</p></div>
                    <button id="btnOptions" class="btn">OPTIONS</button>
                </div> 
                <div id="UserInf">
                    <div id="divPseudo">
                        LOGIN
                    </div>
                    <div id="user_pp_container">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <!-- <div id="divUserPP">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div> -->
                    </div>
                    
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

    <div id="OptionsPopUp">
        <div id="OptBtnsSpace">
            <a href="user_page.html"><button class="btn" id="btnUserSettings">Parametres d'utilisateur</button></a>
            <a href="signIn.html"><button class="btn" id="btnLogin">Se Connecter</button></a>
            <a href="signUp.html"><button class="btn" id="btnCreateAccount">Creer un compte</button></a>
            <button class="btn" id="btnThemes">Themes</button>
            <a href="params_typing.html"><button class="btn" id="btnTypeSettings">Parametres de typing</button></a>
            <button class="btn" id="btnForLater">à faire</button>
            <button class="btn" id="btnBack">Retour</button>
        </div>
    </div>
</body>
<script src="js/script-home.js"></script>
</html>