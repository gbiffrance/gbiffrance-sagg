
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
			<p>FORMULAIRE DE REQUETE POUR ANALYSE SAG</p>
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
					<td width = "20%">
						<p><b><u>Ajouter un champ de recherche</u></b></p>
							
							<!-- 1.Formulaire de choix de parametre de requete -->					
								<form id = "champ">
									<select id = "choix">
						       			<option value="NULL" selected="selected"></option>
									    <option value="Taxon">Taxon</option>
									    <option value="Pays">Pays</option>
									</select>
									<input type = "button" value = "Ajoute champ de recherche" onclick = "ajouteChamp('temp', 'requete', 'choix', 1)"/>
								</form>										
					</td>
					<!-- Case de formulaire 3/4 -->
					<td colspan="3">
					
						<!-- 2.Formulaire de saisie de requete -->
							<form id = "temp" method="post" action="2choixstat.php">
								<div id = "requete"></div>
								<div id = "valid" style = "display:none"><input id =  "Sub" type="submit"  /> <input type="reset" /><br/></div>							
							</form>
					</td>
				</tr>
				
				<tr>
					<!-- Case de requete en cours 4/4 -->
					<td colspan="4">
					</td>					
				</tr>
			</table>
		</div>


<!-- ---------- PIED DE PAGE ---------- -->
		<div id ="pied_de_page">
		
		</div>
		
   </body>
</html>
