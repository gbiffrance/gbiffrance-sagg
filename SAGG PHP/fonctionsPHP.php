<?php
/****************************************************************/
/*	Fonction php pour le moteur d'analyse SAG					*/
/*	Auteur : MAIRE Aurélien (aurelien_maire53@hotmail.com)		*/
/*	Date de création : 3-08-2011								*/
/*	Dernière modification : 3-08-2011							*/
/****************************************************************/

// Fonction qui permet d'acceder à la base de donnée du GBIF
// 	-> $host : l'adresse de la BD, $user : nom de l'utilisateur, $pass : pass de l'utilisateur, $bdd : base donnée a selectionner
// 	<- $dbactive : pointeur vers la base de donnée active 
function openDataBase ($host, $user, $pass, $bdd){
		
	// Connexion au serveur et la base de données et selection de la base de données
	$connect = mysql_connect($host, $user, $pass) or die("erreur de connexion au serveur");
	$dbactive = mysql_select_db($bdd, $connect);
	
	return $dbactive;
}

// Fonction pour recuperer les données fourni dans le formulaire initial
// 	-> $form : Formulaire de recherche
// 	<- $recherche : tableau avec les choix de recherche
function parseFormulaire($form){
	//Initialisation du tableau avec un sous tableau par rype de recherche ect ect
	$recherche = array('Taxon' => array(), 'Pays' => array());
	
	//Pour chaque entrée du formulaire on teste si la clé (sans l'indice) existe dans recherche 
	//puis on associe la valeur dans le tableau recherche à la même clé
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

// Fonction pour creer les conditions du where en fonction de la requete de l'utilisateur
// 	-> $tab : table de recherche (cf. fonction parseFormulaire())
// 	<- $contrainte : chaine de caractère de la contrainte
function mysqlContrainteUtilisateur($tab){
	$contrainte = " ";
	
	foreach($tab AS $key => $value){
		if($contrainte != " " and count($tab[$key]) != 0){$contrainte = $contrainte.") AND (";
		}else if($contrainte == " " and count($tab[$key]) != 0){$contrainte = $contrainte."(";}
	
		$m = 0;
		foreach($tab[$key] AS $i){
			if($m != 0){$contrainte = $contrainte." OR ";}
			$m = 1;
			if($key == 'Taxon'){
				$contrainte = $contrainte. /*" taxon_name.generic = '".$i."' */" taxon_name.canonical = '".$i."' ";
			}else if($key == 'Pays'){
				$contrainte = $contrainte." occurrence_record.iso_country_code = '".$i."' ";
			}
		}
	}
	
	if($contrainte != " "){$contrainte = $contrainte.")";}
	return ($contrainte);
}

// Fonction qui affiche l'heure et un texte
// 	-> $title : Texte avant le "="
//	<- Aucune
function timer($txt){
	echo "<br/>".$txt." = ".date("G").":".date("i").":".date("s")."<br/><br/>";
}

// Fonction qui execute une requete et sort le resultat dans un table avec une case par ligne
// 	-> $REQ : requete à effectuer
//	<- $data : Tableau avec toutes les lignes de reponse
function recupereDonneeSQL($REQ){
	//echo "$REQ <br/><br/>";	
	$rep = mysql_query($REQ);
	mysql_error();
	$data = array();
	while($temp = mysql_fetch_assoc($rep)){
		
		$data[] = $temp;		
	}

	mysql_free_result($rep);
		
	return($data);
}

// Fonction qui donne la liste des groupes taxonomiques directement superieur
// 	-> $taxon : taxon actuel
//	<- $supTax : Nom des taxons d'ordre superieur
function highTaxon($taxon, $Totaljoin){
	openDataBase('192.134.151.151', 'gbifmnhn', 'abcd', 'portal112');
	
	//Definition du tableau de sortie
	$supTaxon = array();

	//Pour chaque cle dans taxon on fait une requete pour trouver les parents
	foreach($taxon AS $T){
										
		$REQ = 	"(SELECT parent_concept_id " .
				"FROM taxon_concept INNER JOIN taxon_name ON (taxon_name.id = taxon_concept.taxon_name_id) " .
				"WHERE taxon_name.canonical = '$T' AND parent_concept_id is not null)";
		
		$parentId = recupereDonneeSQL($REQ);

		//On recherche le nom de rang superieur associe
		$nextRang = nameOfNextRank($T, $Totaljoin);

		//Pour chaque cle dans parent id on cherche les rang taxonomique
		foreach($parentId AS $i){
			
			$SousREQ = 	"(SELECT id, taxon_name_id, rank " .
						"FROM taxon_concept " .
						"WHERE taxon_concept.id = ".$i["parent_concept_id"]." )";
			$REQFinal = "(SELECT canonical " .
						"FROM ($SousREQ T INNER JOIN taxon_name ON (T.taxon_name_id = taxon_name.id)) INNER JOIN rank ON (rank.id = T.rank) " .
						"WHERE rank.name = '$nextRang')";
			
			//On ne selectionne et enregistre que les noms de rangs supérieurs direct et une seule fois par nom		
			$rep = mysql_query($REQFinal);
			while($temp = mysql_fetch_assoc($rep)){
				if(! in_array($temp["canonical"], $supTaxon)){
					$supTaxon[] = $temp["canonical"];			
				}
			}
			mysql_free_result($rep);
		}				
	}
	return($supTaxon);
}

// Fonction qui permet de connaitre le rang directement superieur par rapport a la plus petite entree
// 	-> $tax : Nom du taxon
//	<- $supRang : Nom du rang superieur
function nameOfNextRank($tax, $Totaljoin){
	$rang = recupereDonneeSQL("SELECT DISTINCT rank.name FROM ".$Totaljoin." WHERE taxon_name.canonical = '$tax'");
	$supRang = NULL;
	$suivant = array('species' => 'genus', 'genus' => 'family', 'family' => 'order', 'order' => 'class', 'class' => 'phylum', 'phylum' => 'kingdom');
	$tag = true;
	
	foreach($rang AS $v){
		
		foreach($suivant AS $k => $n){
			
			if($v["name"] == $k && $tag == true){
				$supRang = $n;
				$tag = false;
			}
		}
	}

	return($supRang);
}

// Fonction qui permet de compter n occurence en fonction d'une requete pour connaitre un rang et l'id
// 	-> $temp : objet avec des ligns possedant rang et id associé, $compl : contraite complementaire pour la requete, $TotalJoin : requete du FROM
//	<- $n : Nombre total d'occurence
function CountRequest($recherche, $Totaljoin, $contrainte){

	openDataBase('192.134.151.151', 'gbifmnhn', 'abcd', 'portal112');

	$specReq = " ";
	$flag = true;
	$n = 0;
	
	if(count($recherche["Taxon"]) > 0){	
		foreach($recherche["Taxon"] AS $S){
			if($flag){$flag = false;}else{$specReq = $specReq." OR ";}
			$specReq = $specReq." taxon_name.canonical = '$S' OR taxon_name.generic = '$S' OR taxon_name.supra_generic = '$S'";		
		}
		
		$test = recupereDonneeSQL("SELECT id FROM taxon_name WHERE ".$specReq);
			
		unset($recherche["Taxon"]);
		$ctr2 = mysqlContrainteUtilisateur($recherche);

		foreach($test AS $i){
			$REQ = "SELECT count(*) FROM ".$Totaljoin." WHERE taxon_name.id = ".$i["id"];
			if($contrainte != " "){$REQ = $REQ." AND ".$contrainte;}
			if($ctr2 != " "){$REQ = $REQ." AND ".$ctr2;}
			$temp = recupereDonneeSQL($REQ);
			$n = $temp[0]['count(*)'] + $n;
		}
	}else{
	
		unset($recherche["Taxon"]);
		$ctr2 = mysqlContrainteUtilisateur($recherche);
		$REQ = "SELECT count(*) FROM ".$Totaljoin." WHERE id <-1";
		if($contrainte != " "){$REQ = $REQ." AND ".$contrainte;}
		if($ctr2 != " "){$REQ = $REQ." AND ".$ctr2;}
		$temp = recupereDonneeSQL("SELECT count(*) FROM ".$Totaljoin." WHERE ".$contrainte." AND ".$ctr2);
		$n = $temp[0]['count(*)'];

	
	}
	return($n);
	
}
	
?>
