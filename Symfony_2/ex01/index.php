<?php
include("TemplateEngine.php");
try {
    $template   = new TemplateEngine();
    $template->createFile("./text.html", ["A new Book", "A new shine beyond the stars"]);
} catch (Exception $e) {
    die($e->getMessage());
}
