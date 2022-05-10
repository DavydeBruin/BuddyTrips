<?php
session_start();
require_once('layout/head.php');
$reserveringen = file_get_contents("data/reservering.json");
$reserveringen = json_decode($reserveringen, true);

$reservering = $reserveringen[count($reserveringen) - 1];

// If-statement die checkt of de session bestaat
// Als de session niet bestaat wordt de gebruiker 
// terug gestuurd naar de reserveringspagina
if (!$_SESSION["betalen"]) 
{
    header("location: index.php");
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
                    <p>Hieronder ziet u de reserveringsgegevens. U heeft gekozen
                        om bij het loket te betalen. Dat betekent dat u bij aankomst
                        nog moet betalen.
                    </p>
                </div>
                <div class="group">
                    <span>Naam:</span>
                    <span><?php echo $reservering["naam"] ?></span>
                </div>
                <div class="group">
                    <span>E-Mail:</span>
                    <span><?php echo $reservering["email"] ?></span>
                </div>
                <div class="group">
                    <span>Telefoonnummer:</span>
                    <span><?php echo $reservering["telefoon"] ?></span>
                </div>
                <div class="group">
                    <span>Aantal deelnemers:</span>
                    <span><?php echo $reservering["deelnemers"] ?></span>
                </div>
                <div class="group">
                    <span>Datum rondleiding:</span>
                    <span><?php echo $reservering["datum"] ?></span>
                </div>
                <div class="group">
                    <span>Reisgids:</span>
                    <span><?php echo $reservering["reisgids"] ?></span>
                </div>
                <div class="group">
                    <span>Nog te betalen:</span>
                    <span><?php echo "€" . number_format($reservering["prijs"],2); ?></span>
                </div>
                <div class="description">
                    <p>
                        Het loket bevindt zich op: <br>
                        <span>Damrak 247,1012 ZJ Amsterdam</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<?php
// Session wordt geleegd en vernietigd
unset($_SESSION["betalen"]);
session_destroy();
?>