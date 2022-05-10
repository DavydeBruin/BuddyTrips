<?php
session_start();
require_once('layout/head.php');

// Als de gebruiker op de "Betalen" knop drukt wordt de 
// ingevoerde data gepost in de isset submit if statement
if (isset($_POST['submit'])) 
{
    $prijs = 17.50;
    $deelnemers = intval(($_POST['deelnemers']));
    $datum =  date("m-d-Y", strtotime($_POST['datum']));
    $betaalmethode = ($_POST['betaalmethode']);

    // Functie die de totale prijs berekend door (prijs * aantal deelnemers)
    function berekenTotalePrijs($prijs, $deelnemers)
    {
        $totale_prijs = $prijs * $deelnemers;
        return $totale_prijs;
    }

    // Session die de return value van de totale prijs opslaat in een session
    $_SESSION['prijs'] = berekenTotalePrijs($prijs, $deelnemers);

    // If statement die checkt of het bestand bestaat
    if (file_exists('data/reservering.json')) 
    {
        $reservering_bestand = file_get_contents('data/reservering.json');
        $array_data = json_decode($reservering_bestand, true);

        // Input data door gebruiker in een array stoppen
        $invoer_data = array(
            'naam' => $_POST["naam"],
            'email' => $_POST["email"],
            'telefoon' => $_POST["telefoon"],
            'deelnemers' => $deelnemers,
            'datum' => $datum,
            'betaalmethode' => $_POST["betaalmethode"],
            'reisgids' =>  $_POST["reisgids"],
            'prijs' => $_SESSION['prijs']
        );

        $deelnemers_teller = $deelnemers;

        // Foreachloop die de array uit de reservering loopt
        foreach ($array_data as $reservering) 
        {
            // Checkt of de ingevoerde datum door de gebruiker overeen komt 
            // met de al eerder ingevoerde datum
            if ($datum == $reservering["datum"]) 
            {
                // Deelnemersaantal van gekozen dag bij elkaar optellen
                $deelnemers_teller += intval($reservering["deelnemers"]);
            }
        }

        // Checkt of het aantal deelnemers van die gekozen dag gelijk of onder de 10 zit
        // Als dat zo is wordt de data opgeslagen in een array in het JSON bestand
        // Als het aantal deelnemers boven de 10 zit wordt er een error getoond
        if ($deelnemers_teller <= 10) 
        {
            $array_data[] = $invoer_data;
            $reservering_data = json_encode($array_data);
            file_put_contents('data/reservering.json', $reservering_data);
            // Als de betaalmethode gekozen is voor "nu betalen"
            // stuur gebruiker naar "bevestiging_betalen.php"
            if ($betaalmethode == "betaal-nu") 
            {
                // Session variable "betalen" wordt aangemaakt en ingesteld
                $_SESSION["betalen"] = true;
                header("location: bevestiging_betalen.php");
            }
            // Als de betaalmethode gekozen is voor "bij loket betalen"
            // stuur gebruiker naar "bevestiging_loket.php"
            else if ($betaalmethode == "betaal-loket") 
            {
               // Session variable "betalen" wordt aangemaakt en ingesteld
                $_SESSION["betalen"] = true;
                header("location: bevestiging_loket.php");
            }
        } 
        else 
        {
            $error = "Rondleiding volgeboekt, kies een andere datum!";
        }
    }
}
?>

<body>
    <div class="center">
        <div class="card">
            <div class="container">
                <div class="company-name">
                    <h1>BuddyTrips</h1>
                </div>
                <div class="description">
                    <p>
                        Schrijf je in voor een rondleiding in Amsterdam
                        tussen 12.00 en 18.00 uur voor de prijs van €17,50 p.p.
                    </p>
                </div>
                <form method="POST" onsubmit="return errorValidate()">
                    <div class="row">
                        <div class="form-group">
                            <label for="naam">Naam</label>
                            <input type="text" name="naam" id="naam">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" id="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="telefoon">Telefoonnummer</label>
                            <input type="text" name="telefoon" id="telefoon">
                        </div>
                        <div class="form-group">
                            <label for="deelnemers">Aantal deelnemers</label>
                            <select name="deelnemers" id="deelnemers" onclick="toonPrijsTotaal()">
                                <option selected value>0/10</option>
                                <?php
                                for ($i = 1; $i < 11; $i++) 
                                {
                                    $aantal = $i;
                                ?>
                                    <option value="<?php echo $aantal ?>"><?php echo $aantal ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="datum">Datum rondleiding</label>
                            <input type="date" name="datum" id="datum">
                        </div>
                        <div class="form-group">
                            <label for="reisgids">Reisgids</label>
                            <select name="reisgids" id="reisgids">
                                <?php
                                $data = file_get_contents("data/reisgids.json");
                                $data_reisgids = json_decode($data, true);
                                // Foreach loop die alle reisgidsen uitrolt uit een JSON bestand
                                foreach ($data_reisgids as $data) 
                                {
                                ?>
                                    <option value="<?php echo $data["naam"] ?>"> <?php echo $data["naam"] ?> </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="betaalmethode">Keuzen voor betaling</label>
                        <select name="betaalmethode" id="betaalmethode" onclick="toonKeuzeBetaling()">
                            <option selected value>Betaalmethode</option>
                            <option value="betaal-nu">Nu betalen</option>
                            <option value="betaal-loket">Bij het loket betalen</option>
                        </select>
                    </div>
                    <div class="output">
                        <div class="prijs">
                            <span id="toon-totale-prijs"></span>
                        </div>
                        <!-- Er wordt id "error" in de <p> tag geplaatsts -->
                        <p class="error" id="error">
                            <?php
                            if (isset($error)) 
                            {
                                echo $error;
                            }
                            ?>
                        </p>
                    </div>
                    <button type="submit" name="submit" id="toon-betaal-keuze">Betalen</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/validation.js"></script>
    <script src="js/calculate.js"></script>
</body>

</html>