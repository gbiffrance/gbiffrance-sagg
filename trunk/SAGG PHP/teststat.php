<?php
session_start();
var_dump($_POST);

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
var_dump($recherche);
?>
