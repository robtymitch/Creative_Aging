<?php
require_once("../_classes/DataLoader.php");

//if(!isset($_POST["submit-report"])){
//    header("Location: report_generate.php");
//}
session_start();
$db = \DataLoader\DataHandler::connectToDB();
$query_string = "SELECT program_name, program_topic,
date_start, date_end, facility_name,
num_children, num_adults, num_seniors,
(num_children + num_adults + num_seniors) as total_attendees,
funding_name
FROM programs as p
    INNER JOIN events as e ON e.program_id = p.program_id
    INNER JOIN events_facilities as ef ON ef.event_id = e.event_id
    INNER JOIN facilities as f ON f.facility_id = ef.facility_id
    INNER JOIN funding as fun ON fun.funding_id = ef.funding_id
    ";
$query_total_attendees = "SELECT SUM(num_children + num_adults + num_seniors) as temp_total,
SUM(num_children) as total_children,
SUM(num_adults) as total_adults,
SUM(num_seniors) as total_seniors
FROM programs as p
    INNER JOIN events as e ON e.program_id = p.program_id
    INNER JOIN events_facilities as ef ON ef.event_id = e.event_id
    INNER JOIN facilities as f ON f.facility_id = ef.facility_id
    INNER JOIN funding as fun ON fun.funding_id = ef.funding_id
    ";
$conditions = [];
$err = '';

if (!isset($_POST["submit-report"])) header("Location: report_generate.php");

if ($_POST["dateOpt"] != "allTime") {
    if ($_POST['startDate'] != "") {
        array_push($conditions, 'date_start = ' . $_POST['startDate']);
    }
    if ($_POST['endDate'] != "") {
        array_push($conditions, 'date_end = ' . $_POST['endDate']);
    }
}
if($_POST["fundingOpt"] != "allFundingSources"){
    if ($_POST['fundingType'] != "") array_push($conditions, 'funding_type = "' . $_POST['fundingType'] . '"');
    if ($_POST['fundingSource'] != "") array_push($conditions, 'funding_name = "' . $_POST['fundingSource'] . '"');
}
if ($_POST["facilityOpt"] != "allFacilities") {
    if ($_POST['facility'] != "") array_push($conditions, 'facility_name = "' . $_POST['facility'] . '"');
}




if (count($conditions) > 0) {
    $query_string = $query_string . 'WHERE ' . implode(' AND ', $conditions);
    $query_total_attendees = $query_total_attendees . 'WHERE ' . implode(' AND ', $conditions);
//    echo($query_string);
//    die();
}
$query = $db->prepare($query_string);
$query->execute();

$arr = [];

while ($q = $query->fetch()) {

    array_push($arr, $q);

}

$attendees_query = $db->prepare($query_total_attendees);
$attendees_query->execute();
//
$attendees_arr = [];
//
while ($q = $attendees_query->fetch()) {
//
    array_push($attendees_arr, $q);
//
}
$_SESSION['report'] = $arr;
$_SESSION['report-attendee-total'] = $attendees_arr;
header("Location: report_view.php");
