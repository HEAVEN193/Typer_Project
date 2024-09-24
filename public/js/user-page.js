let btnInfoCompte = document.querySelector("#btnInfoCompte");
let btnStatsCompte = document.querySelector("#btnStatsCompte");
let btnSecuriteCompte = document.querySelector("#btnSecuriteCompte");
let btnParametreTyper = document.querySelector("#btnParamsTyper");





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


document.getElementById('temps').value = storedDuration || '15';
const carSelect = document.getElementById('temps');
console.log(carSelect);

carSelect.addEventListener('change', function() {
    let selectedDuration = this.value;
    gameTime = parseInt(selectedDuration) * 1000;
    localStorage.setItem('gameTime', selectedDuration);
    newGame();
});