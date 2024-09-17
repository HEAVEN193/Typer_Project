const Mode = {
    Typing: 'Typing',
    Options: 'Options',
    Resultat: 'Resultat'
};

let words = 'le main ils penser aider grand pourquoi penser aucun air tout bas donner déménagement ce temps lieu maison image plus bas vieux son moi cause faire ensemble lieu tout de trop petit personnes je temps nous changement côté est allé encore dire genre manière garçon avant ils aucun dire essayer ajouter dehors année vivre utiliser ne là vers aucun fin jouer là ainsi mer moment prendre ciel pays pas voir rendre heure le maison attendre toujours si bon ami chose tant jusque soir homme te donc sur chambre coup rendre mot tête air arriver regard toujours puis faire demander sortir enfant rester voir premier peu en au amour ville genre votre moi âme autre même oui chercher comprendre forme comme bon encore travail'.split(' ');
let wordsCount = words.length;
var text = document.getElementById("CapsLock");
let OptionPopUp = document.querySelector("#OptionsPopUp");
let btnOptions = document.querySelector("#btnOptions");
let btnReplay = document.querySelector('.btnReplay');

const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
let params_time = Number(urlParams.get('time'));

console.log("salut");
let gameTime = 30 * 1000;
window.timer = null;
window.gameStart = null;
let currentMode;
let wordTyped = 0;
let letterTyped = 0;


SetCurrentMode();




function addClass(el,name){
    el.className += ' ' + name;
}

function removeClass(el,name){
    el.className = el.className.replace(name, '');
}

/**
 * Tire un mot au hasard dans la liste word
 * @returns un mot aleatoir dans la liste
 */
function randomWord(){
    let randomIndex = Math.ceil(Math.random() * wordsCount);
    return words[randomIndex - 1];
}


function formatWord(word){
    return `<div class="word"><span class="letter">${word.split('').join('</span><span class="letter">')}</span></div>`;
    
}

function newGame(){
    document.querySelector('.cursor').style.animation = "blink 1s infinite";
    document.querySelector('.words').innerHTML='';
    for(let i = 0; i < 100; i++){
        document.querySelector('.words').innerHTML += formatWord(randomWord());
    }
    addClass(document.querySelector('.word'),'current');
    addClass(document.querySelector('.letter'), 'current');
}

function getWpm(){
    //let words = [...document.querySelectorAll('.word')];
    let AvgCaracByWord = parseInt(letterTyped / wordTyped);
    let lettersCorrect = document.querySelectorAll('.letter.correct').length;
    let result = Math.round((lettersCorrect / AvgCaracByWord)/ gameTime * 60000); 
    return result;
}

function gameOver(){
    clearInterval(window.timer);
    addClass(document.querySelector('.game'), 'over');
    let result = getWpm();
    document.querySelector('.info').innerHTML = `WPM : ${result}`;
}



btnReplay.addEventListener('click', ()=>{
    // gameOver();
    // newGame();
    location.reload();
    // removeClass(document.querySelector('.game'), 'over');
    // removeClass(document.querySelector('.game'), 'over');
    // document.querySelector('.info').innerHTML = gameTime / 1000;
    // document.querySelector('.info').style.border="none";
    // gameTime = 10 * 1000;
    // window.timer = null;
    // window.gameStart = null;
    // document.querySelector('.words').focus();
    // console.log(document.activeElement);
    // document.querySelector('.cursor').style.top=6+"px";
    // document.querySelector('.cursor').style.left=4+"px";


});

window.addEventListener('resize', ()=>{
    moveCursor();
})
window.addEventListener('keydown', (e) => {
    
    let key = e.key;
    let currentWord = document.querySelector('.word.current');
    let currentLetter = document.querySelector('.letter.current');
    let expected = currentLetter?.innerHTML || ' ';
    let isLetter = key.length === 1 && key != ' ';
    let isSpace = key === ' ';
    let isBackSpace = key === 'Backspace';
    let isFirstLetter = currentLetter === currentWord.firstChild;
    
    if(document.querySelector('.game.over')){
        return;
    }


    CheckCapsLock(e);
    OnKeyPressed(e);
    // console.log({ key, expected });

    if(!window.timer && isLetter){
        console.log("oui oui, ca rentre");
        window.timer = setInterval( () => {
            if(!window.gameStart){
                window.gameStart = (new Date()).getTime();
            }
            let currentTime = (new Date()).getTime();
            let msPassed = currentTime - window.gameStart;
            let sPassed = Math.round(msPassed / 1000);
            let sLeft = ((gameTime - 1000) / 1000) - sPassed;
            if(sLeft <= 0){
                gameOver();
                return;
            }
            document.querySelector('.info').innerHTML = sLeft + '';
        }, 1000)
    }

    

    if(isLetter){
        letterTyped++;
        if(currentLetter){
            addClass(currentLetter, key === expected ? 'correct' : 'incorrect');
            removeClass(currentLetter, 'current');

            if(currentLetter.nextSibling){
                addClass(currentLetter.nextSibling, 'current');
            }
        }
            // else{
            //     incorrectLetter = document.createElement('span');
            //     incorrectLetter.innerHTML = key;
            //     incorrectLetter.className = 'letter incorrect extra';
            //     incorrectLetter.style.opacity = "0.5";
            //     currentWord.appendChild(incorrectLetter);
            // }
        
    }
    if (isSpace) {

        wordTyped++;
        if (expected !== ' ') {
            let lettersToInvalidate = [...document.querySelectorAll('.word.current .letter:not(.correct)')];
            lettersToInvalidate.forEach(letter => {
                addClass(letter, 'incorrect');
            });
        }
        
        if (currentLetter) {
            removeClass(currentLetter, 'current');
        }
        

        removeClass(currentWord, 'current');
        addClass(currentWord.nextSibling, 'current');
        addClass(currentWord.nextSibling.firstChild, 'current');
    }

    if (isBackSpace) {
    //let incorrectExtra = document.querySelector('.incorrect.extra.letter');
        

    // if(incorrectExtra){
    //     console.log("oui4");
    //     currentWord.removeChild(currentWord.lastChild);
        
    //     removeClass(currentWord.lastChild, 'incorrect');
    //     removeClass(currentWord.lastChild, 'correct');
    //     removeClass(currentLetter, 'current');
    //     removeClass(currentLetter.previousSibling, 'incorrect'); 

    //     removeClass(currentLetter.previousSibling, 'correct');
    //                 addClass(currentWord.previousSibling.lastChild, 'current');


    // }
        

        if (currentLetter && isFirstLetter) {
            console.log('oui3');
            removeClass(currentWord, 'current');
            addClass(currentWord.previousSibling, 'current');
            removeClass(currentLetter, 'current');
            addClass(currentWord.previousSibling.lastChild, 'current');
            removeClass(currentWord.previousSibling.lastChild, 'incorrect');
            removeClass(currentWord.previousSibling.lastChild, 'correct');

            
        }
        if(currentLetter && !isFirstLetter){
            console.log('oui2');
            removeClass(currentLetter, 'current');
            addClass(currentLetter.previousSibling, 'current');
            removeClass(currentLetter.previousSibling, 'incorrect');
            removeClass(currentLetter.previousSibling, 'correct');
           
        }
        if(!currentLetter){
            addClass(currentWord.lastChild, 'current');
            removeClass(currentWord.lastChild, 'incorrect');
            removeClass(currentWord.lastChild, 'correct');
            console.log("!currentLetter")
        
        }
        console.log(currentWord.previousSibling);
        
        
    }

    /**
     * Défile le texte à partir de la 3ème ligne
     */
    if(currentWord.getBoundingClientRect().top > document.querySelector('.game').getBoundingClientRect().top + 60){ // Si le top du mot actuel est plus grand la moitié de la page
        let words = document.querySelector('.words'); // Conteneur qui contient tout les mots
        let margin = parseInt(words.style.marginTop || "0px"); // Prend le margin top actuelle de "words", le convertir en int, s'il est null il sera égal à 0px
        console.log({margin});
        words.style.marginTop = (margin - 36) + "px"; // Change le top en retirant 35px au top ce qui fera défilé le texte
        for(let i = 0; i < 30; i++){ // Retire 20 nouveaux mots au hasard pour avoir des mots à l'infini (voir plus haut pour précision de son fonctionnement)

            document.querySelector('.words').innerHTML += formatWord(randomWord());
        }

    }

    // Bouge de curseur
    moveCursor(); // prend la position de la lettre ou du mot suivant et ajoute px (utilisation de condition ternaire pour savoir si l'on doit changer le right ou le left)  
});
   
newGame();


function moveCursor(){
    let nextLetter = document.querySelector('.letter.current');
    let nextWord = document.querySelector('.word.current');
    let cursor = document.querySelector('.cursor');
    cursor.style.animation ="none"; // stop le clignotant du cursor quand l'user commence à taper
    cursor.style.transition ="0.2s"; 
    cursor.style.position ="fixed";
    cursor.style.top = (nextLetter || nextWord).getBoundingClientRect().top +2+"px";
    cursor.style.left = (nextLetter || nextWord).getBoundingClientRect()[nextLetter ? 'left' : 'right']+ "px"; // prend la position de la lettre ou du mot suivant et ajoute px (utilisation de condition ternaire pour savoir si l'on doit changer le right ou le left)  
    
}

function OnKeyPressed(e)
{
    if (e.which == 9)
    {
        newGame();
    }
}

function CheckCapsLock(){

}


// When the user presses any key on the keyboard, run the function
window.addEventListener("keyup", function(event) {

  // If "caps lock" is pressed, display the warning text
  if (event.getModifierState("CapsLock")) {
    text.style.color= "green";
  } else {
    text.style.color = "red"
  }
});


btnOptions.addEventListener("click",function()
{
    OptionPopUp.style.display = "block";
    main.style.filter = "blur(5px)";
    PageHeader.style.filter = "blur(5px)";
    console.log("test");
});


// btnBack.addEventListener("click",function()
// {
//     OptionPopUp.style.display = "none";
//     main.style.filter = "none";
//     PageHeader.style.filter = "none";
// });

// btnInfoCompte.addEventListener("click",function(){
//     InfoCompteSpace.style.display = "flex";
//     StatsCompteSpace.style.display = "none";
//     SecuriteCompte.style.display = "none";
//     console.log("test");
// });

// btnStatsCompte.addEventListener("click", function(){
//     InfoCompteSpace.style.display = "none";
//     StatsCompteSpace.style.display = "flex";
//     SecuriteCompte.style.display = "none";
// });

// btnSecuriteCompte.addEventListener("click", function(){
//     InfoCompteSpace.style.display = "none";
//     StatsCompteSpace.style.display = "none";
//     SecuriteCompte.style.display = "flex";
// });



// document.querySelector('#divLogo').addEventListener('click', funct)




//#region Mode

/**
 * Retourn si le mode courant est egal au mode du parametre
 * @param {Mode} mode le mode a comparer avec le mode courant 
 * @returns 
 */
function IsCurrentMode(mode)
{
    return currentMode == mode;
}

/**
 * Change le mode courant en celui du parametre 
 * et appel les fonction EnterMode_...() et ExitMode_...()
 * @param {Mode} mode 
 */
function SetCurrentMode(mode)
{
    if(currentMode == Mode.Typing) ExitMode_Type();
    else if(currentMode == Mode.Options) ExitMode_Options();
    else if(currentMode == Mode.Resultat) ExitMode_Resultat();

    if(mode == Mode.Typing) EnterMode_Type();
    else if(mode == Mode.Typing) EnterMode_Options();
    else if(mode == Mode.Typing) EnterMode_Resultat();

    currentMode = Mode.Resultat;
}






