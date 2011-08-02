<?php
session_start();

$h = date("G");
$m = date("i");
$s = date("s");

$heure_actu = $h.":".$m.":".$s ;

	echo "Debut = ".$heure_actu."<br/>";

//FAUSSE INITIALISATION DE LA VARIABLE $_POST
$_POST['taxon1'] = "Rattus rattus";
$_POST['taxon3'] = "Columba livia";
$_POST['pays2'] = "FR";

//Creation du tableau de requete utilisateur
function parseForm(){
	//Initialisation du tableau avec un sous tableau par rype de recherche ect ect
	$recherche = array('Taxon' => array(), 'Pays' => array());
	
	foreach($_POST as $key => $value){
		if($value != ""){
			if(stristr($key, "taxon")){
				$recherche['Taxon'][] = $value;
			}else if (stristr($key, "pays")){
				$recherche['Pays'][] = $value;
			}		
		}
	}
	return($recherche);
}
$recherche = parseForm();
//print_r(count($recherche));echo "<br/>";
//print_r(count($recherche['Pays']));echo "<br/>";
//print_r(count($recherche['Taxon']));echo "<br/>";
//$plop = count($recherche['Taxon']); print_r($plop > 0);

//Pre phrase SQL
$cleanLoc  = " occurrence_record.latitude < 90 AND occurrence_record.latitude > -90 AND occurrence_record.longitude > -180 AND occurrence_record.longitude < 180 ";
$cleanDate = " occurrence_record.year > 1850 AND occurrence_record.year < YEAR(NOW()) ";
$Scompte = " count(*) ";
$Tocc = "occurrence_record";
$TtName = "taxon_name";
$TtInfo = "taxon_concept";

//Construction de la contrainte selon les différentes entree du formulaire
$contrainte = " ";
foreach($recherche AS $key => $value){
	if($contrainte != " " and count($recherche[$key]) != 0){$contrainte = $contrainte.") AND (";
	}else if($contrainte == " " and count($recherche[$key]) != 0){$contrainte = $contrainte."(";}

	$m = 0;
	foreach($recherche[$key] AS $i){
		if($m != 0){$contrainte = $contrainte." OR ";}
		$m = 1;
		if($key == 'Taxon'){
			$contrainte = $contrainte." ".$TtName.".canonical = '".$i."' ";
		}else if($key == 'Pays'){
			$contrainte = $contrainte." ".$Tocc.".iso_country_code = '".$i."' ";
		}
	}
}
$contrainte = $contrainte.")";

//JOINTURE NECESSAIRE
$join = " (".$TtName." INNER JOIN ".$TtInfo." ON (".$TtName.".id = ".$TtInfo.".taxon_name_id)) INNER JOIN ".$Tocc." ON (".$TtInfo.".id = ".$Tocc.".taxon_concept_id) ";

//EXEMPLE D'ASSOCIATION'
//print_r("SELECT ".$Scompte." FROM ".$join." WHERE ".$contrainte." AND ".$cleanLoc." AND ".$cleanDate);

/////////////////////////////// A FAIRE FONCTION DE RECUPERATION DES DONNEES /////////////////////////



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


	//4 requete de base a info de utilisateur
	$reponse1 = mysql_query("SELECT ".$Scompte." FROM ".$join." WHERE ".$contrainte);
	$reponse2 = mysql_query("SELECT ".$Scompte." FROM ".$join." WHERE ".$contrainte." AND ".$cleanLoc);
	$reponse3 = mysql_query("SELECT ".$Scompte." FROM ".$join." WHERE ".$contrainte." AND ".$cleanDate);
	$reponse4 = mysql_query("SELECT ".$Scompte." FROM ".$join." WHERE ".$contrainte." AND ".$cleanLoc." AND ".$cleanDate);
	
	//Recup valeurs
	$comptebase = mysql_fetch_assoc($reponse1);
	$comptecleanloc = mysql_fetch_assoc($reponse2);
	$comptecleandate = mysql_fetch_assoc($reponse3);
	$comptecleandateloc = mysql_fetch_assoc($reponse4);
	
	$comptebase = $comptebase['count(*)'];
	$comptecleanloc = $comptecleanloc['count(*)'];
	$comptecleandate = $comptecleandate['count(*)'];
	$comptecleandateloc = $comptecleandateloc['count(*)'];

$h = date("G");
$m = date("i");
$s = date("s");

$heure_actu = $h.":".$m.":".$s ;

	echo "Fin = ".$heure_actu;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

   <head>
       <title>Formulaire SAG</title>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <link rel="stylesheet" media="screen" type="text/css" title="style" href="base.css" />
       <script type = "text/javascript" src = "actionFormulaire.js"></script>
   </head>

   <body>

<!-- ---------- HAUT DE PAGE ---------- -->

		<div id="banniere">
			<p>FORMULAIRE DE REQUETE POUR ANALYSE SAG<p>
		</div>


<!-- ---------- MENU ---------- --> 
		<div id="menu">		
			<div class="logo_menu">
		        <a href="formulaire.php"><img src="ornithorynque.jpg" alt="SAG" border="0"/></a>
			</div>
		</div>


<!-- ---------- CORPS DE TEXTE ---------- -->  
		<div id="corps">
			<!-- Tableau du corps de texte -->
			<table border="1" width = "100%" >
				<tr>
					<!-- Sous-menu de formulaire 1/4 -->
					<td width = "30%">
						<p><b><u>DONNEES TROUVEES</b></u>
						<ul>
							<li>Nombre occ total = <? echo $comptebase ?></li>
							<li>Nombre occ daté = <? echo $comptecleandate ?></li>
							<li>Nombre occ localisé = <? echo $comptecleanloc ?></li>							
							<li>Nombre occ daté et localisé= <? echo $comptecleandateloc ?></li>
						</ul></p>				
					</td>
					<!-- Case de formulaire 3/4 -->
					<td colspan="3">
						<a href = "cible.php">test</a>
					</td>
				</tr>
				
				<tr>
					<form id = "stat" method="post" action="teststat.php">
						<td colspan = "2">
							<p><u><b>Analyse temporelle</b></u></p>
							<p><input type = "checkbox" id = "StatTemp" onclick = "affiche('StatTemp', 'sup')">Réaliser</p>
							<div id = "sup" style = "display:none">
								<p><u>Requête comparative</u></p>
								<select id = "choix">
					       			<option value="NULL" selected="selected"></option>
								    <option value="Taxon">Taxon</option>
								    <option value="Pays">Pays</option>
								</select>
								<input type = "button" value = "Ajoute champ de recherche" onclick = "ajouteChamp('stat', 'sup', 0)"/>
								<?php
										$id = 0;
										foreach($recherche AS $key => $value){ 
											foreach($recherche[$key] AS $choix){
												$id = $id + 1;
												echo "<div id =\"".$id."\"><p><u>".$key."</u><input id =\"".$key.$id."\" name = \"".$key.$id."\" type = \"text\"/ value = \"".$choix."\"> <button type = \"button\" name = \"Effacer\" onclick = \"delHTML( ".$id." )\">Effacer</button></p></div>";
											}
										}
									?>
							</div>
							<br/>
						</td>
						<tr><td colspan = "4"><p align = "center"><input id = "valid" type="submit"/></p></td></tr>
					</form>
				</tr>				
			</table>
		</div>


<!-- ---------- PIED DE PAGE ---------- -->
		<div id ="pied_de_page">
		
		</div>
		
   </body>
</html>
<?php
	//AJOUT DE LA REQUETE DE BASE POUR COMPARAISON 
	$_SESSION['requeteBase'] = array(
		'base' 			=> " FROM ".$join." WHERE ".$contrainte,
		'cleanDate'		=> " FROM ".$join." WHERE ".$contrainte." AND ".$cleanDate, 
		'cleanLoc' 		=> " FROM ".$join." WHERE ".$contrainte." AND ".$cleanLoc, 
		'cleanLocDate' 	=> " FROM ".$join." WHERE ".$contrainte." AND ".$cleanLoc." AND ".$cleanDate
	);
	$_SESSION['Comptage'] = array(
		'CompteBase' 	=> $comptebase,
		'CompteDate' 	=> $comptecleandate,
		'CompteLoc' 	=> $comptecleanloc,
		'CompteDateLoc' => $comptecleandateloc
	);
?>