let btnInfoCompte = document.querySelector("#btnInfoCompte");
let btnStatsCompte = document.querySelector("#btnStatsCompte");
let btnSecuriteCompte = document.querySelector("#btnSecuriteCompte");
let btnParametreTyper = document.querySelector("#btnParamsTyper");


let btnEditName = document.querySelector(".edit-name-icon");
let btnEditEmail = document.querySelector(".edit-mail-icon");

let btnSaveParameters = document.querySelector("#btnSaveParameters");

markCurrentButton(btnInfoCompte);


function enableNameInput() {
    const input = document.getElementById('inputPseudo');
    input.disabled = !input.disabled; 
    input.placeholder = input.value;
    input.value = "";
    input.focus(); 
}

function enableEmailInput() {
    const input = document.getElementById('inputMail');
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
    markCurrentButton(btnInfoCompte);
});

btnStatsCompte.addEventListener("click", function(){
    InfoCompteSpace.style.display = "none";
    StatsCompteSpace.style.display = "flex";
    SecuriteCompteSpace.style.display = "none";
    ParametreCompteSpace.style.display = "none";
    markCurrentButton(btnStatsCompte);
});

btnSecuriteCompte.addEventListener("click", function(){
    InfoCompteSpace.style.display = "none";
    StatsCompteSpace.style.display = "none";
    SecuriteCompteSpace.style.display = "flex";
    ParametreCompteSpace.style.display = "none";
    markCurrentButton(btnSecuriteCompte);

});

btnParametreTyper.addEventListener("click", function(){
    InfoCompteSpace.style.display = "none";
    StatsCompteSpace.style.display = "none";
    SecuriteCompteSpace.style.display = "none";
    ParametreCompteSpace.style.display = "flex";
    markCurrentButton(btnParametreTyper);
});

function markCurrentButton(el){
    btnInfoCompte.classList.remove("btnUserPageCurrent");
    btnStatsCompte.classList.remove("btnUserPageCurrent");
    btnSecuriteCompte.classList.remove("btnUserPageCurrent");
    btnParametreTyper.classList.remove("btnUserPageCurrent");
    el.classList.add("btnUserPageCurrent");
}


// Stocké la valeur du temps dans le local storage

let storedDuration = localStorage.getItem('gameTime');
document.getElementById('temps').value = storedDuration || '15';
const carSelect = document.getElementById('temps');


const languageSelect = document.getElementById('languageSelect');
let storedLanguage = localStorage.getItem('gameLanguage');
languageSelect.value = storedLanguage || 'Français';

btnSaveParameters.addEventListener("click", function(){
    let selectedDuration = carSelect.value;
    localStorage.setItem('gameTime', selectedDuration);

    let selectedLanguage = languageSelect.value;
    localStorage.setItem('gameLanguage', selectedLanguage);
});