<?php
include("./Elem.php");
include("./MyException.php");
include("./TemplateEngine.php");

try {

    $html       = new Elem("html");
    $head       = new Elem("head");
    $charset    = new Elem("meta", "charset=\"UTF-8\"");
    $viewport   = new Elem("meta", "name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"");
    $title      = new Elem("title", "My Little Poney");

    $body       = new Elem("body");
    $h1         = new Elem("h1", "My Little Poney");
    $hr         = new Elem("hr");
    $h2         = new Elem("h2", "Description");
    $p          = new Elem("p");
    $span       = new Elem("span", " My Little Pony");
    $div        = new Elem("div");

    $infos      = [
        "The series follows a studious pony named Twilight Sparkle,", 
        " her dragon assistant Spike,", 
        "and her friends Applejack, ",
        "Rarity, ",
        "Fluttershy, ",
        "Rainbow Dash ",
        "and Pinkie Pie."
    ];
    $paraf      = new Elem("p", $infos);
    $img        = new Elem("img", null, ["src" => "https://bit.ly/4f4cAK3", "style" => "size: 10rem"]);
    $table      = new Elem("table");
    $tr         = new Elem("tr");
    $th         = new Elem("th");
    $td         = new Elem("td");
    $ul         = new Elem("ul");
    $li         = new Elem("li");
    // $False      = new Elem("truc"); // Normalement Exception levee ici;

    $head->pushElement($charset);
    $head->pushElement($viewport);
    $head->pushElement($title);
    $html->pushElement($head);
    $body->pushElement($h1);
    $body->pushElement($hr);
    $body->pushElement($h2);
    $body->pushElement($p);
    $div->pushElement($paraf);
    $div->pushElement($img);
    $body->pushElement($div);
    $tr->pushElement($th);
    $tr->pushElement($td);
    $table->pushElement($tr);
    // $table->pushElement($div); // Normalement Exceptiont levee ici;
    $body->pushElement($table);
    $ul->pushElement($li);
    $body->pushElement($ul);
    $html->pushElement($body);

    $Template   = new TemplateEngine($html);
    $Template->createFile("index.html");


} catch (MyException $e) {
    die($e->getMessage());
}

