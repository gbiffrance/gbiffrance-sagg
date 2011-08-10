<?php

$cmd='Rscript --vanilla --slave code.R -s Rattus+rattus -c FR -sc Rattus -cc FR';

$pid=exec($cmd." 2>&1", $output, $return_var);

if($return_var!=0)
{
  echo 'Houston on a un probleme : '. var_dump($output) . '<br>';
  echo 'Derniere Erreur :'.$pid.'<br>';
}
else
  echo 'la commande a reussit avec succes !';


	echo '<br/><br/><br/><br/><br/><br/><br/><u><b>RESULTATS</b></u><br/><br/>';
	//foreach($output AS $v){
	//	echo $v;
	//}
	var_dump($output);
	
	//var_dump($return_var);
?>
