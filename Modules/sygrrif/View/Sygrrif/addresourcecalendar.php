<?php $this->title = "SyGRRiF add pricing"?>

<?php echo $navBar?>

<head>
<!-- Bootstrap core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
#button-div{
	padding-top: 20px;
}

</style>


</head>


<?php include "Modules/sygrrif/View/navbar.php"; ?>

<br>
<div class="container">
	<div class="col-md-10 col-md-offset-1">
	<form role="form" class="form-horizontal" action="sygrrif/addunitpricingquery"
		method="post">
	
		<div class="page-header">
			<h1>
				Ajouter une ressource calendaire <br> <small></small>
			</h1>
		</div>
		<div class="page-header">
			<h3>
				Description <br> <small></small>
			</h3>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-8">Nom</label>
			<div class="col-xs-4">
				<input class="form-control" id="room_name" type="text" name="room_name"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-8">Description</label>
			<div class="col-xs-4">
				<input class="form-control" id="description" type="text" name="description"
				/>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-8">Domaine</label>
			<div class="col-xs-4">
					<select class="form-control" name="id_domaine">
						<?php 
						foreach($domainesList as $domaine){
						?>
							<option value="<?= $this->clean($domaine['id'])?>"> <?= $this->clean($domaine['area_name']) ?> </option>
						<?php 
						}
						?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="inputEmail" class="control-label col-xs-8">Ordre d'affichage</label>
			<div class="col-xs-4">
				<input class="form-control" id="description" type="number" name="order_display" value="0"
				/>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-xs-8">
			Qui peut voir cette ressource (et éventuellement réserver selon les droits attribués) ?
			</div>
			<div class="col-xs-4">
					<select class="form-control" name="who_can_see">
						<option value="0" > N'importe qui allant sur le site même s'il n'est pas connecté </option>
						<option value="1" > Il faut obligatoirement être connecté, même en simple visiteur </option>
						<option value="2" > Il faut obligatoirement être connecté et avoir le statut "utilisateur" </option>
						<option value="3" > Il faut obligatoirement être connecté et être au moins gestionnaire d'une ressource </option>
						<option value="4" > Il faut obligatoirement se connecter et être au moins administrateur du domaine </option>
						<option value="5" > Il faut obligatoirement être connecté et être administrateur de site </option>
						<option value="6" > Il faut obligatoirement être connecté et être administrateur général </option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
					<p>
					Déclarer cette ressource temporairement indisponible. Les réservations sont alors impossibles.
					</p><p>
					<i>La restriction ne s'applique pas aux gestionnaires de la ressource.</i>
					</p>
			</div>
			<div class="col-xs-4">
				<input type="checkbox" name="statut_room">
			</div>
		</div>

		
		<div class="page-header">
			<h3>
				Tarification <br> <small></small>
			</h3>
		</div>
		
		<div class="form-group">
			<label for="inputEmail" class="control-label col-md-2">Biosit</label>
			<div class="col-md-10">
				<div class="col-md-1"><p> Tarif Jour: </p></div>
				<div class="col-md-2"><input class="form-control" id="description" type="number" name="jour_biosit" value="0"/></div>
				<div class="col-md-1"><p> € (H.T.) </p></div>
				<div class="col-md-1"><p> Tarif Nuit: </p></div>
				<div class="col-md-2"><input class="form-control" id="description" type="number" name="jour_biosit" value="0"/></div>
				<div class="col-md-1"><p> € (H.T.) </p></div>
				<div class="col-md-1"><p> Tarif w-e: </p></div>
				<div class="col-md-2"><input class="form-control" id="description" type="number" name="jour_biosit" value="0"/></div>
				<div class="col-md-1"><p> € (H.T.) </p></div>
			</div>
		</div>
		
		
		<div class="page-header">
			<h3>
				Configuration des fonctionnalités <br> 
			</h3>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
			Pour une nouvelle réservation ou modification d'une réservation, l'utilisateur spécifie la date/heure de début de réservation et :
			</div>
			<div class="col-xs-4">
					<select class="form-control" name="type_affichage_reser">
						<option value="0" > La durée de la réservation </option>
						<option value="1" > La date/heure de fin de réservation </option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
			<p>Nombre de personnes maximum autorisé dans la salle (0 s'il ne s'agit pas d'une salle):</p>
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="description" type="number" name="capacity"
				/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
			Nombre max. de réservations par utilisateur (-1 si pas de restriction)
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="description" type="number" name="max_booking" value="-1"
				/>
			</div>
		</div>	
		<div class="form-group">
			<div class="col-xs-8">
			<p>
			Nombre maximal de jours au-delà duquel l'utilisateur ne peut pas réserver ou modifier une réservation (-1 si pas de restriction).
			</p><p>
			<b>Exemple :</b><i> une valeur égale à 30 signifie qu'un utilisateur ne peut réserver une ressource que 30 jours à l'avance au maximum.
Cette limitation ne touche pas les gestionnaires de la ressource ainsi que les administrateurs du domaine: </i></p>
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="description" type="number" name="delais_max_resa_room" value="-1"
				/>
			</div>
		</div>	
		<div class="form-group">
			<div class="col-xs-8">
			<p>
	        Temps <b>en minutes</b> en-deçà duquel l'utilisateur ne peut pas réserver ou modifier une réservation (0 si pas de restriction).
	        </p><p>
            <b>Exemple :</b><i> Exemple : une valeur égale à 60 signifie qu'un utilisateur ne peut pas réserver une ressource ou modifier une réservation moins de 60 minutes avant le début de la réservation.
            Cette limitation ne touche pas les gestionnaires de la ressource ainsi que les administrateurs du domaine.:
            </i></p>
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="description" type="number" name="delais_min_resa_room" value="0"
				/>
			</div>
		</div>	
		<div class="form-group">
			<div class="col-xs-8">
			<p>
	        <b>Poser des réservations "sous réserve" :</b> indiquer une valeur différente de 0 pour activer cette fonctionnalité.
	        </p><p>
			La valeur ci-contre désigne le nombre maximal de jours dont dispose le réservant pour confirmer une réservation.</p>
			</div>
			<div class="col-xs-4">
				<input class="form-control" id="description" type="number" name="delais_option_reservation" value="0"
				/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
			<p>
	        <b>Modérer les réservations de cette ressource</b>
	        <p></p>
            Une réservation n'est effective qu'après validation par un administrateur du domaine ou un gestionnaire de la ressource. :
            </p>
			</div>
			<div class="col-xs-4">
				<input type="checkbox" name="moderate">
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
			<p>
Permettre les réservations dans le passé ainsi que les modifications/suppressions de réservations passées.
<p></p>
Si la case n'est pas cochée, un usager (ni même un gestionnaire ou un administrateur restreint) ne peut effectuer une réservation dans le passé, ni modifier ou supprimer une réservation passée. Seul l'administrateur général a cette possibilité.
            </p>
			</div>
			<div class="col-xs-4">
				<input type="checkbox" name="allow_action_in_past">
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
			<p>
Ne pas permettre aux utilisateurs (hormis les gestionnaires et les administrateurs) de modifier ou de supprimer leurs propres réservations.            </p>
			</div>
			<div class="col-xs-4">
				<input type="checkbox" name="dont_allow_modify">
			</div>
		</div>	
		<div class="form-group">
			<div class="col-xs-8">
			Hormis les administrateurs, précisez ci-contre quels types d'utilisateurs ont le droit de faire des réservations au nom d'autres utilisateurs.
			</div>
			<div class="col-xs-4">
					<select class="form-control" name="qui_peut_reserver_pour">
						<option value="6" > personne </option>
						<option value="4" > uniquement les administrateurs restreints </option>
						<option value="3" > les gestionnaires de la ressource </option>
						<option value="2" > tous les utilisateurs </option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-8">
				Activer la fonctionnalité "ressource empruntée/restituée"			
			</div>
			<div class="col-xs-4">
				<input type="checkbox" name="active_ressource_empruntee">
			</div>
		</div>	
		
		
		<div class="col-xs-4 col-xs-offset-8" id="button-div">
		        <input type="submit" class="btn btn-primary" value="Add" />
				<button type="button" onclick="location.href='sygrrif/unitpricing'" class="btn btn-default" id="navlink">Cancel</button>
		</div>
      </form>
	</div>
</div>

<?php if (isset($msgError)): ?>
<p><?= $msgError ?></p>
<?php endif; ?>
