<?php $this->title = "Storage"?>

<?php echo $navBar?>

<?php
$lang = "En";
if (isset ( $_SESSION ["user_settings"] ["language"] )) {
	$lang = $_SESSION ["user_settings"] ["language"];
}
?>

<head>

<style>
/*----------------------------
    The file upload form
-----------------------------*/

#upload{
    font-family:'PT Sans Narrow', sans-serif;
    background-color:#f1f1f1;

    width:500px;
    padding:30px;
    border-radius:3px;

    margin:200px auto 100px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

#drop{
    background-color: #f1f1f1;
    padding: 40px 50px;
    margin-bottom: 30px;
    border: 20px solid rgba(0, 0, 0, 0);
    border-radius: 3px;
    /*border-image: url('../img/border-image.png') 25 repeat;*/
    text-align: center;
    text-transform: uppercase;

    font-size:16px;
    font-weight:bold;
    color:#7f858a;
}

#drop a{
    background-color:#007a96;
    padding:12px 26px;
    color:#ffffff;
    font-size:14px;
    border-radius:2px;
    cursor:pointer;
    display:inline-block;
    margin-top:12px;
    line-height:1;
}

#drop a:hover{
    background-color: #0986a3;
}

#drop input{
    display:none;
}

#upload ul{
    list-style:none;
    margin:0 -30px;
    border-top:1px solid #e1e1e1;
    border-bottom:1px solid #e1e1e1;
}

#upload ul li{

    background-color:#f1f1f1;

    border-top:1px solid #e1e1e1;
    border-bottom:1px solid #e1e1e1;
    padding:15px;
    height: 80px;

    position: relative;
}

#upload ul li input{
    display: none;
}

#upload ul li p{
    width: 350px;
    overflow: hidden;
    white-space: nowrap;
    color: #585858;
    font-size: 16px;
    font-weight: bold;
    position: absolute;
    top: 20px;
    left: 100px;
}

#upload ul li i{
    font-weight: normal;
    font-style:normal;
    color:#7f7f7f;
    display:block;
}

#upload ul li canvas{
    top: 15px;
    left: 32px;
    position: absolute;
}

#upload ul li span{
    width: 15px;
    height: 12px;
    background: url('externals/fileuploader/img/icons.png') no-repeat;
    position: absolute;
    top: 34px;
    right: 33px;
    cursor:pointer;
}

#upload ul li.working span{
    height: 16px;
    background-position: 0 -12px;
}

#upload ul li.error p{
    color:red;
}
</style>

</head>

<div class="content">

<div class="col-lg-10 col-lg-offset-1">

	<div class="page-header">
		<h1>
			<?= StTranslator::Storage($lang) ?> <br> <small></small>
		</h1>
	</div>
	
	<div class="col-lg-10 col-lg-offset-1">
		<button  type="button"
		onclick="location.href='storage/index'" class="btn btn-primary"><?= StTranslator::Repository($lang) ?></button>
	</div>

	<form id="upload" method="post" action="storage/uploadfile"
		enctype="multipart/form-data">
		<div id="drop">
			Drop Here <br/> <a>Browse</a> <input type="file" name="upl" multiple />
		</div>

		<ul>
			<!-- The file uploads will be shown here -->
		</ul>

	</form>

	<!-- JavaScript Includes -->
	<script src="externals/jquery-1.11.1.js"></script>
	<script src="externals/fileuploader/js/jquery.knob.js"></script>

	<!-- jQuery File Upload Dependencies -->
	<script src="externals/fileuploader/js/jquery.ui.widget.js"></script>
	<script src="externals/fileuploader/js/jquery.iframe-transport.js"></script>
	<script src="externals/fileuploader/js/jquery.fileupload.js"></script>

	<!-- Our main JS file -->
	<script src="externals/fileuploader/js/script.js"></script>

</div>
</div>