<?php
include("./Elem.php");
include("./MyException.php");
include("./TemplateEngine.php");

try {

    $html       = new Elem("html");
    $head       = new Elem("head");
    $charset    = new Elem("meta", null, ["charset" => "UTF-8"]);
    $viewport   = new Elem("meta", null, ["name" => "viewport", "content" => "width=device-width, initial-scale=1.0"]);
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
    $ol         = new Elem("ol");
    $li         = new Elem("li");
    // $False      = new Elem("truc"); // Normalement Exception levee ici;

    $head->pushElement($charset);
    // $head->pushElement($charset); // Error -> to many charsets;
    $head->pushElement($viewport);
    $head->pushElement($title);
    // $head->pushElement($title); // Error -> two titles;
    $html->pushElement($head);
    // $html->pushElement($head); // Error -> two heads;
    $body->pushElement($h1);
    $body->pushElement($hr);
    $body->pushElement($h2);
    $body->pushElement($p);
    // $paraf->pushElement($p); // Error -> $p children;
    // $body->pushElement($paraf); // test with above;
    $div->pushElement($paraf);
    $div->pushElement($img);
    $body->pushElement($div);
    $tr->pushElement($th);
    $tr->pushElement($td);
    // $tr->pushElement($div); // Error -> div in tr
    $table->pushElement($tr);
    // $table->pushElement($div); // Error -> div in table;
    $body->pushElement($table);
    $ul->pushElement($li);
    // $ul->pushElement($div); // Error -> div in ul;
    // $ol->pushElement($div); // Error -> div in ol;
    $body->pushElement($ul);
    $body->pushElement($ol);
    $html->pushElement($body);
    // $html->pushElement($head); // Error -> $head after $body


    $fileName   = "index.html";
    $Template   = new TemplateEngine($html);
    
    if ($html->validPage()) {
        echo "Page ok, file " . (file_exists($fileName) ? "modified" : "created") . PHP_EOL;
        $Template->createFile($fileName);
    }
    else {
        echo "Page not ok, file not " . (file_exists($fileName) ? "modified" : "created") . PHP_EOL;
    }


} catch (MyException $e) {
    die($e->getMessage());
}

