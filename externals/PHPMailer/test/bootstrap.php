<?php
require_once 'vendor/autoload.php';
function  spl_autoload_register ($class) {
    require_once strtr($class, '\\_', '//').'.php';
}
