<head>

<style>
.bs-docs-header {
	position:inherit;
	padding: 15px 15px;
	color: #ffffff;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
	background-color: #337ab7;
}

#navlink {
	color: #ffffff;
	text-shadow: 0 1px 0 rgba(0, 0, 0, .1);
}

.well {
	color: #ffffff;
	background-color: #337ab7;
	border: none;
	-moz-box-shadow: 0px 0px px #000000;
        -webkit-box-shadow: 0px 0px px #000000;
        -o-box-shadow: 0px 0px 0px #000000;
        box-shadow: 0px 0px 0px #000000;
}

#mywell {
	color: #ffffff;
	background-color: #337ab7;
	border: none;
	-moz-box-shadow: 0px 0px px #000000;
        -webkit-box-shadow: 0px 0px px #000000;
        -o-box-shadow: 0px 0px 0px #000000;
        box-shadow: 0px 0px 0px #000000;
}

#mywell legend {
	color: #ffffff;
}

select {
    -moz-appearance: none;
    background: rgba(0, 0, 0, 0) url("Themes/dropdown.png") no-repeat scroll 100% center / 20px 13px !important;
    border: 1px solid #ccc;
    overflow: hidden;
    padding: 6px 20px 6px 6px !important;
    width: auto;
}
</style>

</head>

<?php 
require_once 'Modules/petshop/Model/PsTranslator.php';
$lang = "En";
if (isset($_SESSION["user_settings"]["language"])){
	$lang = $_SESSION["user_settings"]["language"];
}
?>
<div class="bs-docs-header" id="content">
    <div class="container">
		<h2> <?php echo PsTranslator::PetShop($lang) ?> </h2>

		<?php if($_SESSION["user_status"] > 2){ ?>
        	
		<div class='col-md-5 well' id="mywell">
			<fieldset>
				<legend><?php echo PsTranslator::PetShopManagement($lang) ?></legend>
                                
                                <table>
                                    <tr>
                                        <td> 
                                            <button onclick="location.href='pssuppliers'" class="btn btn-link" id="navlink"><?php echo PsTranslator::suppliers($lang) ?></button>
                                            <button onclick="location.href='pssuppliers/edit'" class="btn btn-link" id="navlink">+</button>
                                        </td>
                                        <td> 
                                            <button onclick="location.href='pstypes'" class="btn btn-link" id="navlink"><?php echo PsTranslator::AnimalSpecies($lang) ?></button>
                                            <button onclick="location.href='pstypes/edit'" class="btn btn-link" id="navlink">+</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button onclick="location.href='psproceedings'" class="btn btn-link" id="navlink"><?php echo PsTranslator::Proceeding($lang) ?></button>
                                            <button onclick="location.href='psproceedings/edit'" class="btn btn-link" id="navlink">+</button>
                                        </td>
                                        <td>
                                            <button onclick="location.href='pssectors'" class="btn btn-link" id="navlink"><?php echo PsTranslator::SectorAndPricing($lang) ?></button>
                                            <button onclick="location.href='pssectors/edit'" class="btn btn-link" id="navlink">+</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button onclick="location.href='psentryreason'" class="btn btn-link" id="navlink"><?php echo PsTranslator::EntryReason($lang) ?></button>
                                            <button onclick="location.href='psentryreason/edit'" class="btn btn-link" id="navlink">+</button>
                                        </td>
                                        <td>
                                            <button onclick="location.href='psexitreason'" class="btn btn-link" id="navlink"><?php echo PsTranslator::ExitReason($lang) ?></button>
                                            <button onclick="location.href='psexitreason/edit'" class="btn btn-link" id="navlink">+</button>
			
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <button onclick="location.href='psprojecttypes'" class="btn btn-link" id="navlink"><?php echo PsTranslator::ProjectsTypes($lang) ?></button>
                                            <button onclick="location.href='psprojecttypes/edit'" class="btn btn-link" id="navlink">+</button>
                                         </td>
                                    </tr>
                                </table>    
			</fieldset>
		</div>
		<?php } ?>		
		<div class='col-md-3 well' id="mywell">
			<fieldset>
                            <legend><?php echo PsTranslator::Projects($lang) ?> </legend>
                            <button onclick="location.href='psprojects/'" class="btn btn-link" id="navlink"><?php echo PsTranslator::AllProjects($lang) ?></button>
                            <button onclick="location.href='psprojects/closedProjects'" class="btn btn-link" id="navlink"><?php echo PsTranslator::Closed($lang) ?></button>
                            <button onclick="location.href='psprojects/info/'" class="btn btn-link" id="navlink">+</button>
                
                
                <?php 
                //require_once 'Modules/petshop/model/PsProjectType.php';
                $modelProjectTypeNavBar = new PsProjectType();
                $ptypes = $modelProjectTypeNavBar->getAll();
                
                foreach($ptypes as $ptype){
                    if( $_SESSION["user_status"] > $ptype["who_can_see"]){
                        ?>
                        <br/>
                        <button onclick="location.href='psprojects/index/<?php echo $ptype["id"] ?>'" class="btn btn-link" id="navlink"><?php echo $ptype["name"] ?></button>
                        <button onclick="location.href='psprojects/closedProjects/<?php echo $ptype["id"] ?>'" class="btn btn-link" id="navlink"><?php echo PsTranslator::Closed($lang) ?></button>
                <?php
                    }
                }
                ?>
			</fieldset>
		</div>
		<?php if( $_SESSION["user_status"] > 2){ ?>
                <div class='col-md-3 well' id="mywell">
                    <fieldset>
                            <legend><?php echo PsTranslator::Export($lang) ?></legend>
                            <button onclick="location.href='psexports/listing'" class="btn btn-link" id="navlink"><?php echo PsTranslator::Listing($lang) ?></button>
                            <br/>
                            <button onclick="location.href='psexports/invoice'" class="btn btn-link" id="navlink"><?php echo PsTranslator::Invoicing($lang) ?></button>
                           
                            <button onclick="location.href='psexports/invoiceall'" class="btn btn-link" id="navlink"><?php echo PsTranslator::InvoicingAll($lang) ?></button>
                            <br/>
                            <button onclick="location.href='psinvoicehistory/index'" class="btn btn-link" id="navlink"><?php echo PsTranslator::InvoicingHistory($lang) ?></button>
                    
                    </fieldset>
                </div>
		<?php } ?>
	</div>
</div>
