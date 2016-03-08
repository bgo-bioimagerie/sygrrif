<head>

<style>
.bs-docs-header {
	position: relative;
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
}

#navlink2 {
	color: #cdbfe3;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

#well {
	color: #cdbfe3;
	background-color: #337ab7;
	border: none;
}

legend {
	color: #ffffff;
}
</style>

</head>


<div class="bs-docs-header" id="content">
	<div class="container">
		<h1>Bibliography</h1>
		<div class='col-md-2' id='well'>
		</div>
		
		<div class='col-md-4' id='well'>
			<fieldset>
				<legend>Search Publications</legend>
					<button onclick="location.href='biblio/allpublications'"
						class="btn btn-link" id="navlink2">All</button>
				
					<button onclick="location.href='biblio/yearpublications'"
						class="btn btn-link" id="navlink2">By year</button>
				<br/>
					<button onclick="location.href='biblio/typepublications'"
						class="btn btn-link" id="navlink2">By type</button>
				
					<button onclick="location.href='biblio/authorpublications'"
						class="btn btn-link" id="navlink2">By author</button>
			</fieldset>
		</div>
		<div class='col-md-4' id='well'>
			<fieldset>
				<legend>Add Publication</legend>
				<?php
				$entryTypes = PublicationManager::entriesTypes(); 
				$count = 0;
				foreach ($entryTypes as $entryType){
					$count++;
				?>
					<button onclick="location.href='biblio/editpublication/type_<?php echo $entryType?>'"
						class="btn btn-link" id="navlink2">Add <?php echo $entryType?></button>
						<?php if ($count == 3){?>
					<br/>
						<?php $count = 0;}?>
				<?php 
				}
				?>
			</fieldset>
		</div>
	</div>
</div>


