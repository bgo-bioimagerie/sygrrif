<style>
ul {
    list-style-type: none;
    padding: 0px;
    margin-left: 20px;
}

ul li {
}
</style>

<div class="col-lg-2 col-lg-offset-1" style="background-color: #f1f1f1; margin-top:50px;">

<p><a href="agenda" style="color: #337ab7;">Agenda</a><br/>
<a href="agenda/events" style="color: #337ab7;">fil d'actualité</a></p>

<p>
<?php foreach($eventTypes as $eventType){?>
<a href="agenda/eventsbytype/<?=$eventType["id"] ?>" style="color:#337ab7;"><?= $eventType["name"] ?></a><br/>
<?php } ?>
</p>
</div>
