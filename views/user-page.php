<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/user-page.css">
    <link rel="stylesheet" href="css/style-home.css">
    <script src="https://kit.fontawesome.com/7c6bb8aaf1.js" crossorigin="anonymous"></script>
    <title>User Page</title>
</head>

<body>
    <header>
        <div>
            <div id="divLogo">
                <a href="/"><img id="logo" src="resources/icon/icon_typerPP.png"></img></a>

                <h1>TYPER++</h1>
            </div>
        </div>
        <div>
            <div id="optionsUserInf">
                <div id="divOptions">
                    <!-- <div><p id="CapsLock">Caps Lock</p></div> -->
                    <!-- <button id="btnOptions" class="btn">OPTIONS</button> -->
                </div>
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
                    <div id="user_pp_container">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <div id="mainUser">
        <div id="navbarSpace">
            <div id="navbar">
                <button class="btnUserPage" id="btnInfoCompte">
                    <span>
                        <i class="fa fa-info-circle"aria-hidden="true"></i>
                    </span>
                    <span>Informations</span>
                </button>
                <button class="btnUserPage" id="btnStatsCompte"><span><i class="fa fa-gamepad"></i></span><span>Statistiques</span></button>
                <button class="btnUserPage" id="btnSecuriteCompte"><span><i
                            class="fa fa-lock"></i></span><span>Sécurité</span></button>
                <button class="btnUserPage" id="btnParamsTyper"><span><i class="fa fa-gear"></i></span><span>Paramètres</span></button>
                <a href="/">
                    <button class="btnUserPage" id="btnRetourAccueil">
                        <span>
                            <i class="fa fa-keyboard"></i>
                        </span>
                        <span>Retour menu
                        </span>
                    </button>
                </a>
            </div>
        </div>
        <div id="navSelectSpace">

            <!------------------------INFORMATIONS DU COMPTE -------------------->
            <div id="InfoCompteSpace" class="UserOptionSpaces">
                <div class="containerInfo">
                    <table>
                        <thead>
                            <tr>
                                <th class="title"colspan="2">Informations du compte</th>
                            </tr>
                        </thead>
                        <tr>
                            <td class="col-left">Pseudo : </td>
                            <td class="col-right">
                                <input type="text" name="pseudo" class="inputInfoCompte" disabled value="<?php echo Utilisateur::current()->pseudo; ?>">
                                <i class="pen-to-square"></i>
                           
                            </td>
                        </tr>
                        <tr>
                            <td class="col-left">Email : </td>
                            <td class="col-right">
                            <input type="text" name="pseudo" class="inputInfoCompte" disabled value="<?php echo Utilisateur::current()->addressMail; ?>">
                                <i class="pen-to-square"></i>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-left">Date d'inscripion :</td>
                            <td class="col-right">
                                <input type="text" name="pseudo" class="inputInfoCompte" disabled value="<?php echo Utilisateur::current()->getStatistique()->registrationDate; ?>">
                                <i class="pen-to-square"></i>
                            </td>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

            <!------------------------STATS DU COMPTE -------------------->
            <div id="StatsCompteSpace" class="UserOptionSpaces">
                <div class="containerInfo">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Stats du compte</th>
                            </tr>
                        </thead>
                        <tr>
                            <td class="col-left">Record WPM : </td>
                            <td class="col-right">
                            <?php
                                    // use Matteomcr\TyperProject\Models\Utilisateur;

                                    if(Utilisateur::current())
                                        echo Utilisateur::current()->getHighestScore() . " WPM"; 
                                    else
                                        echo "non connecté";
                                
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-left">Dernier score : </td>
                            <td class="col-right">
                                <?php
                                    // use Matteomcr\TyperProject\Models\Utilisateur;

                                    if(Utilisateur::current())
                                        echo Utilisateur::current()->getLastScore() . " WPM"; 
                                    else
                                        echo "non connecté";
                                
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-left">Partie joué :</td>
                            <td class="col-right">
                                <?php
                                    // use Matteomcr\TyperProject\Models\Utilisateur;

                                    if(Utilisateur::current())
                                        echo Utilisateur::current()->getNumberOfTypingTest(); 
                                    else
                                        echo "non connecté";
                                
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!------------------------SECURITÉ TYPER -------------------->
            <div id="SecuriteCompteSpace" class="UserOptionSpaces">
                <div class="containerInfo">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Sécurité du compte</th>
                            </tr>
                        </thead>
                        <tr>
                            <td class="col-left">Record WPM : </td>
                            <td class="col-right">115 WPM</td>
                        </tr>
                        <tr>
                            <td class="col-left">Dernier score : </td>
                            <td class="col-right">98 WPM</td>
                        </tr>
                        <tr>
                            <td class="col-left">Partie joué :</td>
                            <td class="col-right">12</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!------------------------PARAMETRE TYPER -------------------->
            <div id="ParametreCompteSpace" class="UserOptionSpaces">
                <div class="containerInfo">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Paramètre du typer</th>
                            </tr>
                        </thead>
                        <form id="carForm" action="/">
                            <tr>
                                <label for="car-select"></label><td class="col-left">Temps du test : </td></label>
                                <td class="col-right">
                                    <select id="temps" name="temps">
                                        <option value="15">15 secondes</option>
                                        <option value="30">30 secondes</option>
                                        <option value="45">45 secondes</option>
                                        <option value="60">60 secondes</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-left">Personnalise text :</td>
                                <td class="col-right"> <input type="file" name="file"> </td>
                            </tr>
                            <tr>
                                <td class="col-left">Partie joué :</td>
                                <td class="col-right">12</td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <button type="submit" class="btnSubmit">Sauvegarder</button>
                                </th>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
<script src="js/script-home.js"></script>
<script src="js/user-page.js"></script>

</html>

