<?php
/**
 * Created by IntelliJ IDEA.
 * User: Scuola
 * Date: 20/12/2015
 * Time: 04:15
 */
include_once "librerie/sql.php";
//$host = 'localhost';
//$user = 'root';
//$password = 'Montebaldo1';
//$db = 'rtr';
//
//$connection=mysql_connect($host,$user,$password);
//if (!$connection ) die('Cannot connect: ' . mysql_error());
//$connection=mysql_select_db($db);
//if (!$connection ) die('Cannot connect: ' . mysql_error());
//function query($s, $sub = false) {
//    if ($sub) {
//        $sq = mysql_query ( $s );
//        if (! $sq)
//            die ( 'Cannot connect: Query errata' );
//        return mysql_fetch_assoc ( $sq );
//    } else {
//        $sq = mysql_query ( $s );
//        if (! $sq)
//            die ( 'Cannot connect: Query errata' );
//
//        return $sq;
//    }
//}
$dr2=query("SELECT
 *
FROM live
where id=1");
$ft=mysql_fetch_assoc($dr2);

?>
<script src="https://code.jquery.com/jquery-1.11.1.min.js" type="application/javascript"></script>
<script type="text/javascript" language="javascript">
    function like()
    {
        $.ajax({
            url: "updatemil.php",
            type: "POST",
            data: { 'ingioco': document.getElementById("uno").value, 'totg': document.getElementById("tre").value
                , 'totale': document.getElementById("due").value
                , 'bui': document.getElementById("select_id").value },
            success: function(data)
            {

            }
        });
    }
</script>
<title>Aggiorna</title>
<select id="select_id">
    <option value="1.500/3.000. Ante 300">1.500/3.000. Ante 300</option>
    <option value="2.000/4.000. Ante 400">2.000/4.000. Ante 400</option>
    <option value="2.500/5.000. Ante 500">2.500/5.000. Ante 500</option>
    <option value="3.000/6.000. Ante 600">3.000/6.000. Ante 600</option>
    <option value="4.000/8.000. Ante 800">4.000/8.000. Ante 800</option>
    <option value="5.000/10.000. Ante 1.000">5.000/10.000. Ante 1.000</option>
    <option value="6.000/12.000. Ante 1.200">6.000/12.000. Ante 1.200</option>
    <option value="8.000/16.000. Ante 1.600">8.000/16.000. Ante 1.600</option>
    <option value="10.000/20.000. Ante 2.000">10.000/20.000. Ante 2.000</option>
    <option value="12.500/25.000. Ante 2.500">12.000/25.000. Ante 2.500</option>
    <option value="15.000/30.000. Ante 3.000">15.000/30.000. Ante 3.000</option>
    <option value="20.000/40.000. Ante 4.000">20.000/40.000. Ante 4.000</option>
    <option value="25.000/50.000. Ante 5.000">25.000/50.000. Ante 5.000</option>
    <option value="30.000/60.000. Ante 6.000">30.000/60.000. Ante 6.000</option>
    <option value="40.000/80.000. Ante 8.000">40.000/80.000. Ante 8.000</option>
    <option value="50.000/100.000. Ante 10.000">50.000/100.000. Ante 10.000</option>
</select>
<input id="uno" type="text" value="<?php echo $ft["ingioco"] ?>"/><br>
<input id="tre" type="text" value="<?php echo $ft["totg"] ?>" /><br>
<input id="due" type="text" value="<?php echo $ft["totale"]/1000 ?>" />
<input type="button" value="OK" onclick="like()"/>