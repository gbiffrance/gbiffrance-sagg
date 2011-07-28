<!-- All type of choice on function of element selected in the list -->

<script type="text/javascript">       
          function test(temp) {
          	var i = 0;
          	var j = 0;
          	if(i == 0){
          		var i = 1;
          	}else{
          		var j = j+1;
          	}
          	
			alert(i);
			alert(j);
          }
</script>

<form method="post">
<!-- SPECIES request -->
<div id = "1" style="display:none">

	   <p>
	       <label>Taxon étudié</label> : <input type="text" name="taxon" />
	   </p>
	   
	  


</div>


<!-- COUNTRY request -->
<div id = "2" style="display:none">

	   <p>
	       <label>Pays étudié</label> : <input type="text" name="pays" />
	   </p>


</div>


<!-- TIME INTERVAL request -->
<div id = "3" style="display:none">

	   <p> <label>Date de Début</label> : <input type="text" name="debut" /> </p>
	   <p> <label>Date de Fin</label> : <input type="text" name="fin" /> </p>	   


</div>

<!-- Spatial limite request -->
<div id = "4" style="display:none">

		<p><u>Point centrale : </u></p>
	   <p> <label>Latitude</label> : <input type="text" name="lat" /> <label>Longitude</label> : <input type="text" name="lon" /> </p   
		<p><u>Forme : </u>

		   <p>
		       <input type="radio" name="forme" value="Cercle" id="Cercle" /> <label for="Cercle">Cercle</label><br />
		       <input type="radio" name="forme" value="Carrée" id="Carrée" /> <label for="Carrée">Carrée</label><br />
		   </p>
		
		</p>


		<p><u>Dimension : </u></p>
	   <p> <label>Longeur/rayon</label> : <input type="text" name="taille" />

</div>


<div id = "5" style="display:none">        
   <p>
   	<button type="button" onclick="test(<? $taxon ?>)">Enr</button> 
       <input type="button" onclick = "test()"  /> <input type="reset" />
   </p> 
</div> 
</form>  