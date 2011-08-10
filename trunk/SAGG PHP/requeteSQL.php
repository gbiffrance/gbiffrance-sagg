<?php
/****************************************************************/
/*	Differents utilisateur de requeteur pour requetes SAG		*/
/*	Auteur : MAIRE Aurélien (aurelien_maire53@hotmail.com)		*/
/*	Date de création : 3-08-2011								*/
/*	Dernière modification : 3-08-2011							*/
/****************************************************************/

//Definition des variables
/* LEGEND
 	*T  : table
 	*t  : taxon
 	*n  : name
 	*c  : concept
 	*or : occurence record
 	*r  : rang taxonomique
 	*S  : SELECT paramètre
 	*F  : FROM paramètre 
 	*W  : WHERE paramètre
 */
 
//Pre phrase SQL
$cleanLoc  = " occurrence_record.latitude < 90 AND occurrence_record.latitude > -90 AND occurrence_record.longitude > -180 AND occurrence_record.longitude < 180 ";
$cleanDate = " occurrence_record.year > 1850 AND occurrence_record.year < YEAR(NOW()) ";
$Scompte = " count(*) ";
$Tor = "occurrence_record";
$Ttn = "taxon_name";
$Ttc = "taxon_concept";
$Tr  = "rank";

//JOINTURE NECESSAIRE
$Totaljoin = " ((".$Ttn." INNER JOIN ".$Ttc." ON (".$Ttn.".id = ".$Ttc.".taxon_name_id)) INNER JOIN ".$Tor." ON (".$Ttc.".id = ".$Tor.".taxon_concept_id)) INNER JOIN ".$Tr." ON (".$Ttc.".rank = ".$Tr.".id)";

?>
