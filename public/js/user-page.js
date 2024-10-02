let btnInfoCompte = document.querySelector("#btnInfoCompte");
let btnStatsCompte = document.querySelector("#btnStatsCompte");
let btnSecuriteCompte = document.querySelector("#btnSecuriteCompte");
let btnParametreTyper = document.querySelector("#btnParamsTyper");

let btnEditName = document.querySelector(".edit-name-icon");
let btnEditEmail = document.querySelector(".edit-mail-icon");

function enableNameInput() {
    const input = document.getElementById('inputPseudo');
    input.disabled = !input.disabled; 
    input.placeholder = input.value;
    input.value = "";
    input.focus(); 
}

function enableEmailInput() {
    const input = document.getElementById('inputMail');
     // Donner le focus à l'input après activation
    if(input.disabled){
        input.disabled = !input.disabled; 
        input.focus();
        input.placeholder = input.value;
        input.value = "";
    }
    else{
        input.disabled = !input.disabled; 

    }
    
  }


btnInfoCompte.addEventListener("click",function(){
    InfoCompteSpace.style.display = "flex";
    StatsCompteSpace.style.display = "none";
    SecuriteCompteSpace.style.display = "none";
    ParametreCompteSpace.style.display = "none";
});

btnStatsCompte.addEventListener("click", function(){
    InfoCompteSpace.style.display = "none";
    StatsCompteSpace.style.display = "flex";
    SecuriteCompteSpace.style.display = "none";
    ParametreCompteSpace.style.display = "none";

});

btnSecuriteCompte.addEventListener("click", function(){
    InfoCompteSpace.style.display = "none";
    StatsCompteSpace.style.display = "none";
    SecuriteCompteSpace.style.display = "flex";
    ParametreCompteSpace.style.display = "none";

});

btnParametreTyper.addEventListener("click", function(){
    InfoCompteSpace.style.display = "none";
    StatsCompteSpace.style.display = "none";
    SecuriteCompteSpace.style.display = "none";
    ParametreCompteSpace.style.display = "flex";

    
    
});

// Stocké la valeur du temps dans le local storage

let storedDuration = localStorage.getItem('gameTime');
document.getElementById('temps').value = storedDuration || '15';
const carSelect = document.getElementById('temps');

carSelect.addEventListener('change', function() {
    let selectedDuration = this.value;
    gameTime = parseInt(selectedDuration) * 1000;
    localStorage.setItem('gameTime', selectedDuration);
    newGame();
});