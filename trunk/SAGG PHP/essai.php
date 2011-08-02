<?php
$h = date("G");$m = date("i");$s = date("s");$heure_actu = $h.":".$m.":".$s ;echo "Debut = ".$heure_actu."<br/>";

//Connexion au miroir France
	// Déclaration des paramètres de connexion
	$host = '192.134.151.151';
	$user = 'gbifmnhn';
	$passwd  = 'abcd';
	$bdd = 'portal112';
	
	/*$subject = "taxon1";
	$pattern = '/[0-9]+$/';
	if(stristr($subject, "taxon")){preg_match($pattern, $subject, $temp);print_r($temp);}else{echo "pastrouve";}
	*/
		
	// Connexion au serveur et la base de données
	$connect = mysql_connect($host, $user, $passwd) or die("erreur de connexion au serveur");
	$dbactive = mysql_select_db($bdd, $connect);
	
	$join = "(taxon_name INNER JOIN taxon_concept ON (taxon_name.id = taxon_concept.taxon_name_id)) INNER JOIN rank ON (rank.id = taxon_name.rank)";
	//$rep = mysql_query("SELECT DISTINCT taxon_concept.parent_concept_id FROM ".$join." WHERE taxon_name.canonical = 'Rattus rattus' AND taxon_concept.parent_concept_id <> 'NULL'");
	//$rep = mysql_query("SELECT  count(DISTINCT taxon_concept.parent_concept_id) FROM ".$join." WHERE taxon_name.canonical = 'Rattus rattus'");
	//$rep = mysql_query("SELECT DISTINCT taxon_name.canonical, rank.name FROM ".$join." WHERE taxon_concept.id in (SELECT taxon_concept.parent_concept_id FROM ".$join." WHERE taxon_name.canonical = 'Rattus rattus'  AND taxon_concept.parent_concept_id <> 'NULL')");
	//echo "SELECT count(*) FROM ".$join." WHERE taxon_concept.id = (SELECT taxon_concept.parent_concept_id FROM ".$join." WHERE taxon_name.canonical = 'Rattus rattus'  AND taxon_concept.parent_concept_id <> 'NULL')";
	$rep = mysql_query("SELECT DISTINCT rank.name FROM rank");
	$rep2 = mysql_query("SELECT DISTINCT rank.name, parent_concept_id FROM ".$join." WHERE taxon_name.canonical = 'rattus norvegicus'");
	while($data = mysql_fetch_assoc($rep)){echo "<br/>";var_dump($data);}
	echo "<br/>--------------------------------------------------------------<br/>";
	echo mysql_error();
	$result = array();
	while($data = mysql_fetch_assoc($rep2)){/*echo "<br/>";var_dump($data);*/$result[] = array('name' => $data["name"], 'parent_id' => $data["parent_concept_id"]);}
	
$h = date("G");$m = date("i");$s = date("s");$heure_actu = $h.":".$m.":".$s ;echo "<br/>FIN = ".$heure_actu."<br/>";

$suivant = array('species' => 'genus', 'genus' => 'family', 'family' => 'order', 'order' => 'class', 'class' => 'phylum', 'phylum' => 'kingdom');
$tag = true;
foreach($result AS $v){
	foreach($suivant AS $k => $n){
		if($v['name'] == $k && $tag == true){
			echo "Taxon supérieur est ".$n."<br/>";
			$next = $n;
			$tag = false;
			
		}
	}
}
//echo "SELECT DISTINCT taxon_concept.id FROM ".$join." WHERE rank.id in (SELECT rank.id FROM ".$join." WHERE rank.name = '".$next."') AND taxon_concept.id in (SELECT taxon_concept.parent_concept_id FROM ".$join." WHERE taxon_name.canonical = 'rattus norvegicus' AND taxon_concept.parent_concept_id != 'NULL')";


/*$rep3 = mysql_query(
		"SELECT count(*) " .
		"FROM ".$join." " .
		"WHERE taxon_concept.id in (SELECT DISTINCT taxon_concept.parent_concept_id " .
									"FROM ".$join." " .
									"WHERE taxon_name.canonical = 'rattus norvegicus')"//" //AND taxon_concept.parent_concept_id != 'NULL')"
		);*/
		

				
$REQ = 	"(SELECT parent_concept_id " .
		"FROM taxon_concept INNER JOIN taxon_name ON (taxon_name.id = taxon_concept.taxon_name_id) " .
		"WHERE taxon_name.canonical = 'Rattus rattus' AND parent_concept_id is not null)";
		
$REQ2 = "(SELECT id, taxon_name_id, rank " .
		"FROM taxon_concept " .
		"WHERE taxon_concept.id in $REQ )";
		
$REQ3 = "(SELECT canonical " .
		"FROM $REQ2 T INNER JOIN taxon_name ON (T.taxon_name_id = taxon_name.id) " .
		"WHERE T.rank = 6000)";
	
echo $REQ;
echo "<br/>--------------------------------------------------------------<br/>";
echo $REQ2;
echo "<br/>--------------------------------------------------------------<br/>";
echo $REQ3;
echo "<br/>--------------------------------------------------------------<br/>";

$rep3 = mysql_query($REQ3);
echo mysql_error();

//$rep3 = mysql_query("SELECT rank.id FROM rank WHERE rank.name = '".$next."'");
//$rep3 = mysql_query("SELECT count(*) FROM ".$join." WHERE rank.name = '".$next."'");
//$rep3 = mysql_query("SELECT count(DISTINCT taxon_concept.parent_concept_id, taxon_name.canonical) FROM ".$join." WHERE taxon_name.canonical = 'rattus norvegicus' AND taxon_concept.parent_concept_id != 'NULL' AND rank.id = 6000");
//echo "SELECT DISTINCT taxon_concept.parent_concept_id, taxon_name.canonical FROM ".$join." WHERE taxon_name.canonical = 'rattus norvegicus' AND taxon_concept.parent_concept_id != 'NULL' AND rank.name = '".$next."'";
//var_dump($next);
	while($data = mysql_fetch_assoc($rep3)){echo "<br/>";var_dump($data);}



$h = date("G");$m = date("i");$s = date("s");$heure_actu = $h.":".$m.":".$s ;echo "<br/>FIN = ".$heure_actu."<br/>";

?>
