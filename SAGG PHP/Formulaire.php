
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >

<script type="text/javascript">
          function selection(select) {
          	
            var opt=select.getElementsByTagName("option" );
            for (var i=0; i<opt.length; i++) {
              var x=document.getElementById(opt[i].value);
              if (x) x.style.display="none";
            }
            var cat = document.getElementById(select.value);
            if (cat) cat.style.display="block";
          }
</script>
        
   <head>
       <title>GBIF France SAG</title>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   </head>
 
   <body>
     
       <!-- Le corps -->
 
       <div id="corps">
           <h1>GBIF France SAG</h1>
       
       		<p>Veuillez choisir votre paramètre de requête</p>
       		<!-- <form action="cible.php" method="post">-->
	       		<select onchange = "selection(this)">
	       			<option value="0" selected="selected"></option>
				    <option value="1">Espèce</option>
				    <option value="2">Pays</option>
				    <option value="3">Interval de temps</option>
				    <option value="4">Localisation géographique</option>
				</select>
				<? include("submenu.php") ?>
			<!--</form>-->

       </div>
 
       <!-- Le pied de page -->
 
       <div id="pied_de_page">
           <p>Copyright moi, tous droits réservés</p>
       </div>
 
   </body>
</html>
