// Functie die de totale prijs berekend door (prijs * aantal deelnemers)
function berekenTotalePrijs() 
{
    let aantalDeelnemers = document.getElementById("deelnemers").value;
    let prijs = 17.50;
    let prijsTotaal = (prijs  * aantalDeelnemers).toFixed(2);

    return prijsTotaal;
}

// Functie die de waarde van de totale prijs in de HTML stopt
function toonPrijsTotaal() 
{
    document.getElementById("toon-totale-prijs").innerHTML = `Prijs = €${berekenTotalePrijs()}`;
}

// Functie die de betaalmethode veld waarde ophaald en omzet in een variable.
// Vervolgens wordt er gecheckt of de ingevoerde waarde van de betaalmethode keuze gelijk is aan 
// de optie "Bij het loket betalen", als dat zo is krijgt de betaalmethode de tekst "Reserveren".
// Anders behoudt de betaalmethode knop de tekst "Betalen"
function keuzeBetaling() 
{
    let betaalmethode = document.getElementById("betaalmethode").value;

    if (betaalmethode == 'betaal-loket') 
    {
        betaalmethode = 'Reserveren';
    }
    else 
    {
        betaalmethode = 'Betalen';
    }

    return betaalmethode;
}

// Functie die de return waarde uit de functie "keuzeBetaling" 
// op het id "toon-betaal-keuze" in de HTML plaatst
function toonKeuzeBetaling() 
{
    document.getElementById("toon-betaal-keuze").innerHTML = `${keuzeBetaling()}`;
}

