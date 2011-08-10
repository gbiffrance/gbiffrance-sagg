<?php
	session_start();
	include "fonctionsPHP.php";
	include "requeteSQL.php";

	timer("Start");
	
	//FAUSSE INITIALISATION DE LA VARIABLE $_POST
	//$_POST['taxon1'] = "Rattus";
	//$_POST['taxon3'] = "Columba livia";
	//$_POST['pays2'] = "FR";	
	$recherche = parseFormulaire($_POST);
	$contrainte = mysqlContrainteUtilisateur($recherche);

	if(count($recherche) > 0){$next = highTaxon($recherche["Taxon"], $Totaljoin);}else{$next = NULL;}
	
	//openDataBase('192.134.151.151', 'gbifmnhn', 'abcd', 'portal112');
	
	//4 requete de base a info de utilisateur
	$Tot 		= CountRequest($recherche, $Totaljoin, " ");
	$TotDate 	= CountRequest($recherche, $Totaljoin, $cleanLoc);
	$TotLoc 	= CountRequest($recherche, $Totaljoin, $cleanDate);
	$TotDateLoc = CountRequest($recherche, $Totaljoin, $cleanLoc." AND ".$cleanDate);

	timer("End");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

   <head>
       <title>Formulaire SAG</title>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <link rel="stylesheet" media="screen" type="text/css" title="style" href="base.css" />
       <script type = "text/javascript" src = "fonctionsJS.js"></script>
   </head>

   <body>

<!-- ---------- HAUT DE PAGE ---------- -->

		<div id="banniere">
			<p>FORMULAIRE DE REQUETE POUR ANALYSE SAG<p>
		</div>


<!-- ---------- MENU ---------- --> 
		<div id="menu">		
			<div class="logo_menu">
		        <a href="1formulaire.php"><img src="ornithorynque.jpg" alt="SAG" border="0"/></a>
			</div>
		</div>


<!-- ---------- CORPS DE TEXTE ---------- -->  
		<div id="corps">
			<!-- Tableau du corps de texte -->
			<table border="1" width = "100%" >
				<tr>
					<!-- Sous-menu de formulaire 1/4 -->
					<td width = "30%">
					
						<!-- 1. Presentation des données -->
						<p><b><u>DONNEES TROUVEES</b></u>
						<ul>
							<li>Nombre occ total = <? echo $Tot ?></li>
							<li>Nombre occ daté = <? echo $TotDate ?></li>
							<li>Nombre occ localisé = <? echo $TotLoc ?></li>							
							<li>Nombre occ daté et localisé= <? echo $TotDateLoc ?></li>
						</ul></p>
										
					</td>
					<!-- Case de formulaire 3/4 -->
					<td colspan="3">
					</td>
				</tr>
				
				<tr>
				
					<!-- 2. Analyse des temporel et parametre possible -->
					<form id = "list">
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
								<input type = "button" value = "Ajoute champ de recherche" onclick = "ajouteChamp('stat', 'stat', 'choix', 0)"/>
							</div>
						</form>
							<div id = "statBlock">								
								<form id = "stat" method="post" action="3validstat.php">
								<?php
										$id = 0;
										foreach($recherche AS $key => $value){ 
											foreach($recherche[$key] AS $choix){
												
												echo "<div id =\"".$id."\"><p><u>".$key."</u><input id =\"".$key.$id."\" name = \"".$key.$id."\" type = \"text\"/ value = \"".$choix."\"> <button type = \"button\" name = \"Effacer\" onclick = \"delHTML( ".$id." )\">Effacer</button></p></div>";
												$id = $id + 1;
											}
										}
										$n = 0;
										?>
										</div>
										<?php
										echo "<b>Rang taxonomique superieur possible :</b>";
										foreach($next AS $i){
											if($n != 0){echo ",";}
											$n = 1;
											echo " $i";
										}
										echo ".";
									?>
							
							<br/>
						</td>
						
						<!-- 3. Envoi des données -->
						<tr><td colspan = "4"><p align = "center"><input id = "valid" type="submit"/></p></td></tr>
						</div>
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

	/*ENREGISTREMENT DANS MA VARIABLE SESSION DES DIFFERENTS PARAMETRES UTILISABLES*/
	//AJOUT DE LA REQUETE DE BASE POUR COMPARAISON 
	$_SESSION['Comptage'] = array(
		'CompteBase' 	=> $Tot,
		'CompteDate' 	=> $TotDate,
		'CompteLoc' 	=> $TotLoc,
		'CompteDateLoc' => $TotDateLoc
	);
	$_SESSION['recherche'] = $recherche;
?>