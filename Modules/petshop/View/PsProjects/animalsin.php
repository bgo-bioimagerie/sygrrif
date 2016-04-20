<?php $this->title = "Pltaform-Manager" ?>

<?php echo $navBar ?>

<head>
    <!-- Bootstrap core CSS -->
    <link href="externals/datepicker/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet">
    

</head>



<?php include "Modules/petshop/View/petshopnavbar.php"; ?>
<?php include "Modules/petshop/View/Psprojects/tabs.php"; ?>

<br>
<div class="col-md-12">
    <p></p>
</div>


<form role="form" class="form-horizontal" action="psprojects/exitanimals" method="post">
    <div class="col-md-12">
        <div class="col-md-1 col-md-offset-11">
            <input type="hidden" name="id_project" value="<?php echo $id_project ?>"/> 
            <input type="submit" class="btn btn-sm btn-primary" value="<?php echo PsTranslator::ExitAnimal($lang) ?>" />
            <p></p>
        </div>
    </div>     
    <div class="col-md-12">   
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th class="text-center"><?php echo PsTranslator::NoAnimal($lang) ?></th>
                    <th class="text-center"><?php echo PsTranslator::BirthDate($lang) ?></th>
                    <th class="text-center"><?php echo PsTranslator::DateEntry($lang) ?></th>
                    <th class="text-center"><?php echo PsTranslator::Lineage($lang) ?></th>
                    <th class="text-center"><?php echo PsTranslator::Sexe($lang) ?></th>
                    <th class="text-center"><?php echo CoreTranslator::user($lang) ?></th>
                    <th class="text-center"><?php echo CoreTranslator::Unit($lang) ?></th>
                    <th class="text-center"><?php echo PsTranslator::Sector($lang) ?></th>
                    <th class="text-center"><?php echo PsTranslator::NoRoom($lang) ?></th>
                    <th class="text-center"><?php echo PsTranslator::Observation($lang) ?></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($animals as $animal) {
                    ?>
                    <tr>
                        <td><input type="checkbox" name="chk_<?php echo $animal["id"] ?>"></td>
                        <td><?php echo $animal["no_animal"] ?></td>
                        <td><?php echo $animal["birth_date"] ?></td>
                        <td><?php echo $animal["date_entry"] ?></td>
                        <td><?php echo $animal["lineage"] ?></td>
                        <td><?php echo $animal["sexe"] ?></td>
                        <td><?php echo $animal["userName"] . " " . $animal["userFirstname"] ?></td>
                        <td><?php echo $animal["hist"][0]["unitName"] ?></td>
                        <td><?php echo $animal["hist"][0]["sectorName"] ?></td>
                        <td><?php echo $animal["hist"][0]["no_room"] ?></td>
                        <td><?php echo $animal["observation"] ?></td>
                        <td><button type='button' onclick="location.href = 'psanimals/edit/<?php echo $animal["id"] ?>'" class="btn btn-sm btn-primary"><?php echo CoreTranslator::Edit($lang) ?></button></td>
                        <td><button type='button' onclick="ConfirmDelete<?php echo $animal["id"]?>();" class="btn btn-sm btn-danger"><?php echo CoreTranslator::Delete($lang) ?></button></td>

                    </tr>
                    
                    <script type="text/javascript">
                    function ConfirmDelete<?php echo $animal["id"]?>()
                    {
                        if (confirm( "<?php echo PsTranslator::ConfirmDeleteAnimal($lang) . $animal["no_animal"] . "?" ?>" )){
                            location.href='psprojects/deleteanimalin/<?php echo $this->clean($animal["id"] )?>';
                        }
                    }
                    </script>
                    <?php
                }
                ?>
            </tbody>
        </table>
</form>
</div>

        

<?php if (isset($msgError)): ?>
    <p><?php echo $msgError ?></p>
    <?php

 endif;
