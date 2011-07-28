function ecritureCaseTexte(id, nom)
{
 	addHTML(document.getElementById('requete'), "<div id = \""+id+"\"><p><u>" + nom + " :</u> <input id = \" " + nom + "_" + id + "\" name = \"" + nom+"_"+id + "\" type = \"text\"/> <button type = \"button\" name = \"Effacer\" onclick = \"delHTML( "+id+" )\">Effacer</button></p></div>");
}

function addHTML(element, HTML) {
  var o = document.createElement("htmlSection");
  o.innerHTML = HTML;
  element.appendChild(o);
}

function delHTML(id) {
	document.getElementById(id).parentNode.removeChild(document.getElementById(id));
}

function ajouteChamp(){

	var x=document.getElementById("temp").getElementsByTagName("input");
	
	if(document.getElementById("choix").value == "Taxon") {
		ecritureCaseTexte(x.length-1, "Taxon");
	} else if (document.getElementById("choix").value == "Pays") {
		ecritureCaseTexte(x.length-1, "Pays");
	}
	document.getElementById('valid').style.display="block";	
}