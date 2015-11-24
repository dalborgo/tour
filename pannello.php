<?php
echo "<title>Pannello di Controllo</title>";
include_once "librerie/specific.php";
$format = date('Y-m-d');
$seco = date('Y-m-d', (strtotime('-1 day', strtotime($format))));
$a = strtotime($seco . '07:00:00');
$b = strtotime($format . '06:59:59');
$toy = $a . "~" . $b;

//$format="2015-09-14";
$terzo = date('Y-m-d', (strtotime('-1 day', strtotime($seco))));
$c = strtotime($terzo . '07:00:00');
$colore = (isLocale()) ? "papayawhip" : "white";
$testo = (isLocale()) ? "Locale" : "Online";
$ultimo = (isLocale()) ? "" : "<br><br><a href='http://localhost/tmp/tour/pannello.php'>Pannello Locale</a><br/>";
?>
<div style="padding:0px 10px 0px 10px;width:164px;background-color:<?php echo $colore; ?>">
    <h4><?php echo $testo; ?></h4>
<!--    <a href="http://www.dalborgo.com/shark/cm.php?tipo=l&d=--><?php //echo $toy ?><!--">0. CM (online)</a><br/>-->
    <a href="http://www.dalborgo.com/shark/cm.php?tipo=l">0. CM (online)</a><br/>
    <a href="creadati.php">1. Crea Dati</a><br/>
    <a href="salvaGenerale.php">2. Salva Generale</a><br/>
    <a href="salvaPois.php">3. Salva Pois</a><br/>
    <a href="creaStatsGen.php">4. Crea Stats</a><br/>
    <a href="creaNomi.php">5. Crea Nomi</a><br/><br/>

    <a href="./pl/">Edita Database</a><br/>
    <a href="agg_players.php">Aggiorna Player</a><br/>
    <a href="http://localhost/tmp/tour/agg_players.php?f=si">Aggiorna Player F (offline)</a><br/>
    <a href="agg_ranking.php">Aggiorna Ranking</a><br/>
    <a href="http://www.dalborgo.com/ryder/azz_blog.php">Azzera Blog</a><br/>
    <a href="gruppi/myphp.php">Gruppi</a><br/>
    <a href="shark.php">Shark</a><br/>
    <a href="controllo.php?a=<?php echo $c ?>&b=<?php echo $a ?>&c=Bosca95">Controllo Bosca95</a><br/>
    <a href="controllo.php?a=<?php echo $c ?>&b=<?php echo $a ?>&c=pokerale17">Controllo Poker</a><br/>
    <a href="controllo.php?a=<?php echo $c ?>&b=<?php echo $a ?>&c=thecogo">Controllo cogo</a><br/>
    <a href="controllo.php?a=<?php echo $c ?>&b=<?php echo $a ?>&c=Giuliocesare5">Controllo Giulio</a><br/>
    <a href="controllo.php?a=<?php echo $c ?>&b=<?php echo $a ?>&c=DamaNera">Controllo DamaNera</a><br/>
    <a href="controllo.php?a=<?php echo $c ?>&b=<?php echo $a ?>&c=TOPMODEL61">Controllo Top</a><br/>
    <a href="patchdati.php?a=<?php echo $c ?>&b=<?php echo $a ?>&c=25.000">Patcha</a><br/>
    <a href="patchdati.php?a=<?php echo $c ?>&b=<?php echo $a ?>&e=1000">Patcha Entranti</a>
    <?php echo $ultimo; ?><br />
    <a href="generale.html">GENERALE</a><br/>
    <a href="http://www.dalborgo.com/shark/sm.php">LIVE</a><br/>

</div>
