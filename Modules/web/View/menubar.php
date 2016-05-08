<?php 
require_once 'Modules/web/Model/WbMenu.php';
$modelWbMenu = new WbMenu();
$menuItems = $modelWbMenu->selectAll("display_order");

$modelConfig =  new CoreConfig();
?>

<div class="navbar-wrapper" >
      <div class="container">

        <nav class="navbar navbar navbar-fixed-top" style="background-color: #fff;">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="home">
              <img style="max-width:100px; margin-top: -13px;"
             src="<?php echo $modelConfig->getParam("webMenuIcon"); ?>">
             </a>
                <span style="font-size: 24;">
                    <?php echo $modelConfig->getParam("webMenuTitle"); ?>
                </span>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right">
                <?php foreach($menuItems as $item){ ?>
                <li><a href="<?php echo $item["url"] ?>"><?php echo $item["name"]?></a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </nav>

      </div>
    </div>