<html><body>
<?php
session_sart();
$_SESSION = "Bidouille";
$h = date("G");
$m = date("i");
$s = date("s");

$heure_actu = $h.":".$m.":".$s ;

	echo $heure_actu;
	echo "<br/>";echo "<br/>";echo "<br/>";
	$_POST['taxon'] = 'ratus ratus';
	$_POST['pays'] = 'FR';

	//var_dump($_POST);

	// Déclaration des paramètres de connexion
	$host = '192.134.151.151';

	// Généralement la machine est localhost
	// c'est-a-dire la machine sur laquelle le script est hébergé

	$user = 'gbifmnhn';

	$bdd = 'portal112';

	$passwd  = 'abcd';

// Connexion au serveur
$connect = mysql_connect($host, $user, $passwd) or die("erreur de connexion au serveur");

$dbactive = mysql_select_db($bdd, $connect);

//$reponse = mysql_query("SELECT * FROM occurrence_record WHERE year = '1920'");
//$reponse = mysql_query("SELECT * FROM taxon_name WHERE canonical = 'rattus'");
$reponse1 = mysql_query("SELECT count(*) FROM (taxon_name INNER JOIN taxon_concept ON (taxon_name.id = taxon_concept.taxon_name_id)) INNER JOIN occurrence_record ON (taxon_concept.id = occurrence_record.taxon_concept_id) WHERE taxon_name.canonical = 'Rattus rattus'");
$reponse2 = mysql_query("SELECT count(*) FROM (taxon_name INNER JOIN taxon_concept ON (taxon_name.id = taxon_concept.taxon_name_id)) INNER JOIN occurrence_record ON (taxon_concept.id = occurrence_record.taxon_concept_id) WHERE taxon_name.canonical = 'rattus' AND occurrence_record.latitude < 90 AND occurrence_record.latitude > -90 AND occurrence_record.longitude > -180 AND occurrence_record.longitude < 180 AND iso_country_code ='FR'");
$reponse3 = mysql_query("SELECT count(*) FROM (taxon_name INNER JOIN taxon_concept ON (taxon_name.id = taxon_concept.taxon_name_id)) INNER JOIN occurrence_record ON (taxon_concept.id = occurrence_record.taxon_concept_id) WHERE taxon_name.canonical = 'rattus' AND occurrence_record.year > 1850 AND occurrence_record.year < 2011");
$reponse4 = mysql_query("SELECT count(*) FROM (taxon_name INNER JOIN taxon_concept ON (taxon_name.id = taxon_concept.taxon_name_id)) INNER JOIN occurrence_record ON (taxon_concept.id = occurrence_record.taxon_concept_id) WHERE taxon_name.canonical = 'rattus'  AND occurrence_record.year > 1850 AND occurrence_record.year < 2011 AND occurrence_record.latitude < 90 AND occurrence_record.latitude > -90 AND occurrence_record.longitude > -180 AND occurrence_record.longitude < 180");
$reponse5 = mysql_query("SELECT DISTINCT rank.name, taxon_concept.genus_concept_id FROM ((taxon_name INNER JOIN taxon_concept ON (taxon_name.id = taxon_concept.taxon_name_id)) INNER JOIN occurrence_record ON (taxon_concept.id = occurrence_record.taxon_concept_id))INNER JOIN rank ON (rank.id =taxon_name.rank) WHERE taxon_name.canonical = 'RATTUS' AND occurrence_record.year > 1850 AND occurrence_record.year < 2011 AND occurrence_record.latitude < 90 AND occurrence_record.latitude > -90 AND occurrence_record.longitude > -180 AND occurrence_record.longitude < 180 AND iso_country_code ='FR'");
$reponse6 = mysql_query("SELECT count(*) FROM ((taxon_name INNER JOIN taxon_concept ON (taxon_name.id = taxon_concept.taxon_name_id)) INNER JOIN occurrence_record ON (taxon_concept.id = occurrence_record.taxon_concept_id))INNER JOIN rank ON (rank.id =taxon_name.rank) WHERE taxon_name.canonical = 'RATTUS' AND occurrence_record.year > 1850 AND occurrence_record.year < 2011 AND occurrence_record.latitude < 90 AND occurrence_record.latitude > -90 AND occurrence_record.longitude > -180 AND occurrence_record.longitude < 180 AND iso_country_code ='FR'");


if (!$reponse5) {
    $message  = 'Requête invalide : ' . mysql_error() . "\n";
    //$message .= 'Requête complète : ' . $query;
    die($message);
}

	$donnees = mysql_fetch_assoc($reponse1);
	echo "compte total de donnees : ".$donnees['count(*)']."<br/>";
	$donnees = mysql_fetch_assoc($reponse2);
	echo "compte total de donnees avec loc : ".$donnees['count(*)']."<br/>";
	$donnees = mysql_fetch_assoc($reponse3);
	echo "compte total de donnees avec date : ".$donnees['count(*)']."<br/>";
	$donnees = mysql_fetch_assoc($reponse4);
	echo "compte total de donnees avec loc et date : ".$donnees['count(*)']."<br/>";
	$donnees = mysql_fetch_assoc($reponse6);
	echo "compte total de donnees avec loc et date et pays : ".$donnees['count(*)']."<br/>";
	
	while($donnees = mysql_fetch_assoc($reponse5)){
		echo "<br/>";var_dump($donnees);
	}
	
echo "<br/>";echo "<br/>";echo "<br/>";
$h = date("G");
$m = date("i");
$s = date("s");

$heure_actu = $h.":".$m.":".$s ;
	echo $heure_actu;

mysql_free_result($reponse1);
mysql_free_result($reponse2);
mysql_free_result($reponse3);
mysql_free_result($reponse4);
mysql_free_result($reponse5);
mysql_free_result($reponse6);
/*try
{
    // On se connecte à MySQL
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $bdd = new PDO('host='+$host+';dbname='+$bd, $user, $passwd, $pdo_options);
    
    // On récupère tout le contenu de la table jeux_video
    $reponse = $bdd->query('SELECT * FROM raw_occurrence_record');
    
    // On affiche chaque entrée une à une
    while ($donnees = $reponse->fetch())
    {
		echo $donnees['data_provider_id'];
    }
    
    $reponse->closeCursor(); // Termine le traitement de la requête

}
catch(Exception $e)
{
    // En cas d'erreur précédemment, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}
*/

?>
</html></body>