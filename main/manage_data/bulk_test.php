<?php
require_once("../_classes/DataLoader.php");
$db = \DataLoader\DataHandler::connectToDB();

add25Programs($db);


function add25Programs($db){
    if(!($db instanceof PDO)){
        throw new Exception("Function expects PDO Object for database parameter");
    }
    $program_name_adjectives = [
        "Rootin' tootin'",
        "Happy",
        "Swashbuckling",
        "Senior",
        "Starlit"
    ];
    $program_name_type = [
        "Knitting",
        "Song and dance",
        "Comedy",
        "Bob Hope",
        "Wellness"
    ];
    $program_name_subjects = [
        "Show",
        "Event",
        "Jamboree",
        "Celebration",
        "Bonanza"
    ];



    $program_topics = [
        "music",
        "art",
        "wellness",
        "drama",
        "history/culture"
    ];

    $query = "INSERT INTO programs(program_name, program_topic) VALUES ";




    $name = "'" . $program_name_adjectives[rand(0, 4)] . " " . $program_name_type[rand(0, 4)] . " " . $program_name_subjects[rand(0, 4)] . "'";
    $topic = "'" . $program_topics[rand(0, 4)] . "'";



}
function add25Facilities($db){

}
function add25Funding($db){

}
function add25Events($db){

}



