<?php $this->title = "Zoomify"?>

<?php echo $navBar?>

<?php
$lang = "En";
if (isset ( $_SESSION ["user_settings"] ["language"] )) {
	$lang = $_SESSION ["user_settings"] ["language"];
}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="externals/zoomify/ZoomifyImageViewer.js"></script>
<style type="text/css"> #myContainerRecherche { width:900px; height:550px; margin:auto; border:1px; border-style:solid; border-color:#696969;} </style>
<script type="text/javascript"> Z.showImage("myContainerRecherche", "data/zoomify/example", "zFullPageVisible=0&zToolbarVisible=0&zNavigatorVisible=1&zFullPageVisible=0&zLogoCustomPath=Assets/LogoCustom/logo_h2p2.jpg"); </script>
								
</head>
<!--  
<head>
		

		<script type="text/javascript" src="externals/zoomify/ZoomifyImageViewer.js"></script>
		<style type="text/css"> #myContainerRecherche { width:900px; height:550px; margin:auto; border:1px; border-style:solid; border-color:#696969;} </style>
		<script type="text/javascript"> Z.showImage("myContainerRecherche", "data/zoomify/ZoomifyImageExample"); </script>

</head>
-->

<div style="margin-top: 50px;">
								<!--<a class="circle"></a>-->
								<div id="nameFileRecherche">
									
								</div>
								
								<div id="myContainerRecherche"></div>
								
								
								<div style="text-align:center; padding:10px; background: #fff; height: 15%;">
									<form name="myForm" id="myForm">
										<input class="btn btn-default" type="button" name="zoomOut" id="zoomOut" value="Zoom Out" onMouseDown="Z.Viewport.zoom('out')" onMouseUp="Z.Viewport.zoom('stop')" onTouchStart="Z.Viewport.zoom('out')" onTouchEnd="Z.Viewport.zoom('stop')"/>
										<input class="btn btn-default" type="button" name="zoomIn" id="zoomIn" value="Zoom In" onMouseDown="Z.Viewport.zoom('in')" onMouseUp="Z.Viewport.zoom('stop')" onTouchStart="Z.Viewport.zoom('in')" onTouchEnd="Z.Viewport.zoom('stop')"/>
										<input class="btn btn-default" type="button" name="panLeft" id="panLeft" value="Pan Left" onMouseDown="Z.Viewport.pan('left')" onMouseUp="Z.Viewport.pan('stop')" onTouchStart="Z.Viewport.pan('left')" onTouchEnd="Z.Viewport.pan('stop')"/>
										<input class="btn btn-default" type="button" name="panUp" id="panUp" value="Pan Up" onMouseDown="Z.Viewport.pan('up')" onMouseUp="Z.Viewport.pan('stop')" onTouchStart="Z.Viewport.pan('up')" onTouchEnd="Z.Viewport.pan('stop')"/>
										<input class="btn btn-default" type="button" name="panDown" id="panDown" value="Pan Down" onMouseDown="Z.Viewport.pan('down')" onMouseUp="Z.Viewport.pan('stop')" onTouchStart="Z.Viewport.pan('down')" onTouchEnd="Z.Viewport.pan('stop')"/>
										<input class="btn btn-default" type="button" name="panRight" id="panRight" value="Pan Right" onMouseDown="Z.Viewport.pan('right')" onMouseUp="Z.Viewport.pan('stop')" onTouchStart="Z.Viewport.pan('right')" onTouchEnd="Z.Viewport.pan('stop')"/>
										<input class="btn btn-default" type="button" name="reset" id="reset" value="Reset" onClick="Z.Viewport.reset()"/>
										<input class="btn btn-default" type="button" name="fullPage" id="fullPage" value="Full Page" onClick="Z.Viewport.toggleFullPageViewExternal()"/>
									</form>
								</div>


<div style="margin-top: 50px;">
	<div id="myContainer"></div>
	
</div>