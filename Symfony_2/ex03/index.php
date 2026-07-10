<?php
include("./Elem.php");
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
$b          = new Elem("b", "My Little Pony: Friendship Is Magic");
$text       = new Elem("", " is an animated television series based on Hasbro's");
$span       = new Elem("span", " My Little Pony");
$text2      = new Elem("", " franchise and marking the start of its fourth incarnation.");
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


try {
    
    $head->pushElement($charset);
    $head->pushElement($viewport);
    $head->pushElement($title);
    $html->pushElement($head);
    $body->pushElement($h1);
    $body->pushElement($hr);
    $body->pushElement($h2);
    $p->pushElement($b);
    $p->pushElement($text);
    $p->pushElement($span);
    $p->pushElement($text2);
    $body->pushElement($p);
    $div->pushElement($paraf);
    $body->pushElement($div);
    $html->pushElement($body);
    echo $html->getHTML();


} catch (Exception $e) {
    die($e->getMessage());
}

