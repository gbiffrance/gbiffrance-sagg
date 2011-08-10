//Rajoute du code html DANS une balise precise
function ecritureCaseTexte(loc, id, nom)
{
 	addHTML(document.getElementById(loc), "<div id = \""+id+"\"><p><u>" + nom + " :</u> <input id = \" " + nom + id + "\" name = \"" + nom+id + "\" type = \"text\"/> <button type = \"button\" name = \"Effacer\" onclick = \"delHTML( "+id+" )\">Effacer</button></p></div>");
}

//Fonction qui permet d'ecrire du code html en direct
function addHTML(element, HTML) {
  var o = document.createElement("htmlSection");
  o.innerHTML = HTML;
  element.appendChild(o);
}

//Fonction qui permet de retirer l'ensemble d'une balise et de ses composants
function delHTML(id) {
	document.getElementById(id).parentNode.removeChild(document.getElementById(id));
}

//Fonction qui permet d'ajouter en champ et de creer une id logique
function ajouteChamp(form, loc, id, valid){

	var x=document.getElementById(form).getElementsByTagName("input");
	
	if(document.getElementById(id).value == "Taxon") {
		ecritureCaseTexte(loc, x.length, "Taxon");
	} else if (document.getElementById(id).value == "Pays") {
		ecritureCaseTexte(loc, x.length, "Pays");
	}
	if(valid == 1){document.getElementById('valid').style.display="block";}
}

//DOnction qui permet d'afficher un div si une check box est coché
function affiche(id, id2){
	if(document.getElementById(id).checked == true){
		document.getElementById(id2).style.display="block";
	}else{
		document.getElementById(id2).style.display="none";
	}
}
