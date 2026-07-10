<?php
include("./HotBeverage.php");
include("./Tea.php");
include("./Coffee.php");
include("./TemplateEngine.php");

$teaPot     = new Tea();
$coffeeCup  = new Coffee();
$CocoaMilk  = new HotBeverage("CocoaMilk", 3.4012, 42.42);
$template   = new TemplateEngine();
try {
    $template->createFile($teaPot);
    $template->createFile($coffeeCup);
    $template->createFile($CocoaMilk);
} catch (Exception $e) {
    die($e->getMessage());
}
