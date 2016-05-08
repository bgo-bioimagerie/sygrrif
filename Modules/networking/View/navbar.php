<style>
.bs-glyphicons{margin:10px -10px 0px 0px;overflow:hidden}
.bs-glyphicons-list{padding-left:0;list-style:none}
.bs-glyphicons li{float:left;width:100%;height:30px;padding-left:10px;
font-size:10px;line-height:1.4;text-align:center;background-color:#e9eaed;border:0px solid #fff}

.bs-glyphicons .glyphicon{margin-top:5px;margin-bottom:10px;font-size: 14px; color: #000;}
.bs-glyphicons .glyphicon-class{display:block;text-align:left;word-wrap:break-word}

.bs-glyphicons li:hover{color:#fff;background-color:#337ab7}@media (min-width:768px){
.bs-glyphicons{margin-right:0;margin-left:0}
.bs-glyphicons li{width:100%;font-size:10px}
}

.bs-glyphicons li a{color:#888888;}
.bs-glyphicons li a:hover{color:#fff;}
.bs-glyphicons .glyphicon-class:hover{color:#fff;}

</style>

<div class="col-md-2">
    
    <p style="text-transform: uppercase; color: #666666; font-weight: bold; font-size: 12px;"> <?php echo NtTranslator::Tools($lang) ?> </p>
    <div class="bs-glyphicons">
    <ul class="bs-glyphicons-list">
        
        <li>
            <a href="ntaccount">
                <span class="glyphicon-class glyphicon glyphicon-user" aria-hidden="true"> <?php echo NtTranslator::MyProfile($lang) ?></span>
            </a>
        </li>
        <!--
        <li>    
            <a href="networking">
                <span class="glyphicon-class glyphicon glyphicon-list-alt" aria-hidden="true"> <?php echo NtTranslator::Newsfeed($lang) ?></span>
            </a>
        </li>
        -->
        <li> 
            <a href="ntgroups">
                <span class="glyphicon-class glyphicon glyphicon-globe" aria-hidden="true"> <?php echo NtTranslator::Groups($lang) ?></span>
            </a>
        </li>
        <li>     
            <a href="ntprojects">
                <span class="glyphicon-class glyphicon glyphicon-tasks" aria-hidden="true"> <?php echo NtTranslator::Projects($lang) ?></span>
            </a>
        </li>
        
        </ul>
    </div>
    <p></p>
    <p style="text-transform: uppercase; color: #666666; font-weight: bold; font-size: 12px;"> <?php echo NtTranslator::Notifications($lang) ?> </p>
</div>
