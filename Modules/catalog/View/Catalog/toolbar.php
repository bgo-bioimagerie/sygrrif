<?php $this->title = "Catalog"?>

<?php echo $navBar?>
<?php require_once 'Modules/catalog/Model/CaTranslator.php';?>

<head>
    <link rel='stylesheet prefetch' href='externals/photoswipe/css/photoswipe.css'>
	<link rel='stylesheet prefetch' href='externals/photoswipe/default-skin.css'>
	<link rel="stylesheet" href="externals/photoswipe/css/style.css">
</head>
<style>

a.mybuttonactive {
 /* display et dimensions */
 display: inline-block;
 width: 200px;
 height: 50px;
 /* centrage vertical */
 line-height: 50px;
 vertical-align: middle;
 /* centrage horizontal */
 text-align: center;
 /* font style */
 font-family: Arial,sans-serif;
 font-size: medium; 
 color: white;
 text-decoration: none;
 font-weight: bold;
 /* background style */
 background: #337ab7;
}

a.mybutton {
 /* display et dimensions */
 display: inline-block;
 width: 200px;
 height: 50px;
 /* centrage vertical */
 line-height: 50px;
 vertical-align: middle;
 /* centrage horizontal */
 text-align: center;
 /* font style */
 font-family: Arial,sans-serif;
 font-size: medium; 
 color: #337ab7;
 text-decoration: none;
 font-weight: bold;
 /* background style */
 background: #ffffff;
 border: 1px solid #337ab7;
}

a.mybutton:hover { background: #337ab7; color: #ffffff; border: 1px solid #337ab7;}

</style>
<div class="page-header">
	<h1> <?php echo CaTranslator::Catalog($lang) ?></h1>
</div>
<br/>
<div class="col-md-12" style="text-align:center;">
	<?php foreach ($categories as $cat){
            $buttonStyle = "mybutton";
            if ($cat["id"] == $activeCategory){
                $buttonStyle = "mybuttonactive";
            }
            ?>
            <a class="<?php echo $buttonStyle ?>" href="catalog/index/<?php echo $cat["id"]?>"><?php echo $cat["name"]?></a>
            <?php 
	}
        ?>

</div>
