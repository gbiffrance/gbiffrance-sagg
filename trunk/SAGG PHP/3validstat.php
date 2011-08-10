<?php
	session_start();
	include "fonctionsPHP.php";
	include "requeteSQL.php";

	timer("Start");
	
	//FAUSSE INITIALISATION DE LA VARIABLE $_POST
	//$_POST['taxon1'] = "Rattus";
	//$_POST['taxon3'] = "Columba";
	//$_POST['pays2'] = "FR";
	var_dump($_POST);
	$rechercheComp = parseFormulaire($_POST);

	//openDataBase('192.134.151.151', 'gbifmnhn', 'abcd', 'portal112');

	//4 requete de base a info de utilisateur
	$TotComp 		= CountRequest($rechercheComp, $Totaljoin, " ");
	$TotDateComp 	= CountRequest($rechercheComp, $Totaljoin, $cleanLoc);
	$TotLocComp		= CountRequest($rechercheComp, $Totaljoin, $cleanDate);
	$TotDateLocComp = CountRequest($rechercheComp, $Totaljoin, $cleanLoc." AND ".$cleanDate);

	//echo "Tot = $TotComp <br/>TotDate = $TotDateComp <br/>TotLoc = $TotLocComp <br/>TotDateLoc = $TotDateLocComp <br/>";

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
						<p><b><u>DONNEES REQUETE DE BASE</b></u>
						<ul>
							<li>Nombre occ total = <? echo $_SESSION['Comptage']['CompteBase'] ?></li>
							<li>Nombre occ daté = <? echo $_SESSION['Comptage']['CompteDate'] ?></li>
							<li>Nombre occ localisé = <? echo $_SESSION['Comptage']['CompteLoc'] ?></li>							
							<li>Nombre occ daté et localisé= <? echo $_SESSION['Comptage']['CompteDateLoc'] ?></li>
						</ul></p>
										
					</td>
					<!-- Case de formulaire 1/4 -->
					<td colspan="3">
						<p><b><u>DONNEES REQUETE COMPARATIVE</b></u>
						<ul>
							<li>Nombre occ total = <? $prct = round(100*($TotComp-$_SESSION['Comptage']['CompteBase'])/$_SESSION['Comptage']['CompteBase'], 2);
													echo ($TotComp." <i>(+$prct %)</i>"); ?></li>
							<li>Nombre occ daté = <? $prct = round(100*($TotDateComp-$_SESSION['Comptage']['CompteDate'])/$_SESSION['Comptage']['CompteDate'], 2);
													echo ($TotDateComp." <i>(+$prct %)</i>"); ?></li>
							<li>Nombre occ localisé = <? $prct = round(100*($TotLocComp-$_SESSION['Comptage']['CompteLoc'])/$_SESSION['Comptage']['CompteLoc'], 2);
													echo ($TotLocComp." <i>(+$prct %)</i>"); ?></li>							
							<li>Nombre occ daté et localisé= <? $prct = round(100*($TotDateLocComp-$_SESSION['Comptage']['CompteDateLoc'])/$_SESSION['Comptage']['CompteDateLoc'], 2);
													echo ($TotDateLocComp." <i>(+$prct %)</i>"); ?></li>
						</ul></p>
						
					</td>
					<!-- Case de formulaire 2/4 -->
					<td colspan="2">
					</td>
				</tr>
				
				<tr>
									
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
	$_SESSION['ComptageComp'] = array(
		'CompteBaseComp' 	=> $TotComp,
		'CompteDateComp' 	=> $TotDateComp,
		'CompteLocComp' 	=> $TotLocComp,
		'CompteDateLocComp' => $TotDateLocComp
	);
	$_SESSION['rechercheComp'] = $rechercheComp;
?>