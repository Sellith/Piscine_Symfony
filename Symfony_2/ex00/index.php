<?php
include("TemplateEngine.php");
try {
    $template   = new TemplateEngine();
    $template->createFile(
        "LoTR.html", 
        "book_description.html", 
        [ 
            "nom" => "Lotr", 
            "auteur" => "Jrr Tolkien", 
            "description" => "A nice book about a Hobbit getting a ring and it's journey to destroy it", 
            "prix" => "&infin" 
        ]);
} catch (Exception $e) {
    die($e->getMessage());
}
?>
