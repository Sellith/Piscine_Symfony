<?php
include("TemplateEngine.php");
include("./Text.php");

try {
    $template   = new TemplateEngine();
    $text       = new Text(["A new Book", "A new shine beyond the stars"]);
    $template->createFile("./text.html", $text);
    $text->append("New opportunities");
    $template->createFile("./text2.html", $text);
} catch (Exception $e) {
    die($e->getMessage());
}
