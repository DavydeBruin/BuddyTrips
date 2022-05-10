let naam = document.getElementById("naam");
let email = document.getElementById("email");
let telefoon = document.getElementById("telefoon");
let deelnemers = document.getElementById("deelnemers");
let datum = document.getElementById("datum");
let reisgids = document.getElementById("reisgids");
let betaalmethode = document.getElementById("betaalmethode");
let error = document.getElementById("error");

// Functie die loopt over een array van formuliervelden aan de hand van een id
// en controleert of ze leeg zijn of niet
function errorValidate() 
{
    let returnValue = true;
    const input = ["naam", "email", "telefoon", "deelnemers", "datum", "reisgids", "betaalmethode"];
    input.forEach((item) => 
    {
        if (document.getElementById(item).value == '') 
        {
            returnValue = false;
        }
    })

    if (returnValue == false) 
    {
        error.style.display = "block";
        let msg = "Niet alle gegevens zijn ingevoerd!";
        error.innerHTML = msg;
        return false;
    }
    
    // If statement die checkt of de lengte van het ingevoerde telefoonnummer 
    // niet gelijk is aan 10 karakters. Als dat zo is komt er een foutmelding.
    // Pas als er 10 karakters zijn gebruikt wordt de deelnemer doorgevoerd in de validatie.
    if (telefoon.value.toString().length != 10) 
    {
        error.style.display = "block";
        let msg = "Een telefoonnummer heeft 10 karakters!";
        error.innerHTML = msg;
        return false;
    }

    return returnValue;
}

