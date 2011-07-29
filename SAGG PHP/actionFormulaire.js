function ecritureCaseTexte(loc, id, nom)
{
 	addHTML(document.getElementById(loc), "<div id = \""+id+"\"><p><u>" + nom + " :</u> <input id = \" " + nom + id + "\" name = \"" + nom+id + "\" type = \"text\"/> <button type = \"button\" name = \"Effacer\" onclick = \"delHTML( "+id+" )\">Effacer</button></p></div>");
}

function addHTML(element, HTML) {
  var o = document.createElement("htmlSection");
  o.innerHTML = HTML;
  element.appendChild(o);
}

function delHTML(id) {
	document.getElementById(id).parentNode.removeChild(document.getElementById(id));
}

function ajouteChamp(form, loc, valid){
	gccgvghbn 
	var x=document.getElementById(form).getElementsByTagName("input");
	
	if(document.getElementById("choix").value == "Taxon") {
		ecritureCaseTexte(loc, x.length-1, "Taxon");
	} else if (document.getElementById("choix").value == "Pays") {
		ecritureCaseTexte(loc, x.length-1, "Pays");
	}
	if(valid == 1){document.getElementById('valid').style.display="block";}
}
