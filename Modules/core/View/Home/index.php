<?php $this->title = "SyGRRiF Database" ?>

<?php echo $navBar ?>

<div class="container">
	<!-- Main component for a primary marketing message or call to action -->
	<div class="jumbotron">
        <h1>SyGRRif</h1>
        <p>L'outil SyGRRif permet d'éditer des statistiques et facurations à partir d'un GRR et d'une base de donnée</p>
        <p>Les statistiques sont accessibles depuis le menu <b>data</b> et la base de données est administrable par les outils 
           disponibles depuis le menu <b>admin</b> </p>
	</div>

</div> <!-- /container -->




<?php if (isset($msgError)): ?>
    <p><?= $msgError ?></p>
<?php endif; ?>
