<?php

function drawAgenda($mois, $annee, $entries){
	
	$list_fer=array(7);//Liste pour les jours ferié; EX: $list_fer=array(7,1)==>tous les dimanches et les Lundi seront des jours fériers
	$list_spe=array('1986-10-31','2015-3-17','2009-9-23');//Mettez vos dates des evenements ; NB format(annee-m-j)
	$lien_redir="date_info.php";//Lien de redirection apres un clic sur une date, NB la date selectionner va etre ajouter à ce lien afin de la récuperer ultérieurement
	
	$mois_fr = Array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août","Septembre", "Octobre", "Novembre", "Décembre");
	
	
	$l_day=date("t",mktime(0,0,0,$mois,1,$annee));
	$x=date("N", mktime(0, 0, 0, $mois,1 , $annee));
	$y=date("N", mktime(0, 0, 0, $mois,$l_day , $annee));
	?>
	
	
	<div style="width:900px;">



	<!-- 
	<caption><?= $mois_fr[$mois] . " " . $annee ?></caption>
	 -->
	 
	<table class="tableau">
	<caption>
	
	<div class="col-md-2" style="text-align: left;">
		<button type="button" onclick="location.href='agenda/index/p_<?=$mois?>_<?= $annee ?>'" class="btn btn-default"> Previous </button>
	</div>
	<div class="col-md-8">
		<p ><strong> <?= $mois_fr[$mois] . " " . $annee ?></strong></p>
	</div>
	<div class="col-md-2" style="text-align: right;">	
		<button type="button" onclick="location.href='agenda/index/n_<?=$mois?>_<?= $annee ?>'" class="btn btn-default"> Next </button>
	</div>
	</div>
	</caption>
	<tr><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th></tr>
	<tr>
	<?php
	$case=0;
	if($x>1)
		for($i=1;$i<$x;$i++)
		{
			echo '<td class="desactive">&nbsp;</td>';
			$case++;
		}
	for($i=1;$i<($l_day+1);$i++)
	{
		$f=$y=date("N", mktime(0, 0, 0, $mois,$i , $annee));
		$da=$annee."-".$mois."-".$i;
		echo "<td>";
	
		?>
		<div style="text-align:right; font-size:12px; color:#999999;"> <?= $i ?> </div>
		<?php 
		$found = false;
		foreach ($entries as $entry){
			if (date("d", strtotime($entry["date_begin"])) == $i){
				$found = true;
				?>
				<a href="agenda/events/<?=$entry["id"] ?>">
				<div style="background-color: <?= $entry["type_color"] ?>; max-width:200px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;" >
				<p style="border-bottom: thin solid #818181; font-size:10px; color:#313131;" >
				 <?php echo $entry["time_begin"] . " - " . $entry["time_end"] ?></p>
				<p style="font-size:12px; color:#313131;"><?= $entry["title"] ?></p>
				</div>
				</a>
				<?php
			}
		}
		if($found == false){
			?>
			<div style="height:45px;"> </div>
			<?php 
		}
		
		echo "</td>";
		$case++;
		if($case%7==0)
			echo "</tr><tr>";
		
	}
	if($y!=7)
		for($i=$y;$i<7;$i++)
		{
			echo '<td class="desactive">&nbsp;</td>';
		}
	?></tr>
	</table>
	<?php 
}
?>