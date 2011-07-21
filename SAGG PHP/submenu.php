<!-- All type of choice on function of element selected in the list -->

<!-- SPECIES request -->
<div id = "1" style="display:none">
	<form method="post">
	   <p>
	       <label>Taxon étudié</label> : <input type="text" name="taxon" />
	   </p>
</form>

</div>


<!-- COUNTRY request -->
<div id = "2" style="display:none">
	<form method="post">
	   <p>
	       <label>Pays étudié</label> : <input type="text" name="pays" />
	   </p>
</form>

</div>


<!-- TIME INTERVAL request -->
<div id = "3" style="display:none">
	<form method="post">
	   <p> <label>Date de Début</label> : <input type="text" name="debut" /> </p>
	   <p> <label>Date de Fin</label> : <input type="text" name="fin" /> </p>	   
</form>

</div>

<!-- Spatial limite request -->
<div id = "4" style="display:none">
	<form method="post">
		<p><u>Point centrale : </u></p>
	   <p> <label>Latitude</label> : <input type="text" name="lat" /> <label>Longitude</label> : <input type="text" name="lon" /> </p>	</form>   
		<p><u>Forme : </u>
		<form method="post">
		   <p>
		       <input type="radio" name="forme" value="Cercle" id="Cercle" /> <label for="Cercle">Cercle</label><br />
		       <input type="radio" name="forme" value="Carrée" id="Carrée" /> <label for="Carrée">Carrée</label><br />
		   </p>
		
		</p>
</form>
	<form method="post">
		<p><u>Point centrale : </u></p>
	   <p> <label>Longeur/rayon</label> : <input type="text" name="taille" /></form>  

</div>