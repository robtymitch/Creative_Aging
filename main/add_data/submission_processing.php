<?php
require_once("../_classes/DataLoader.php");
$db = \DataLoader\DataHandler::connectToDB();

if ($_POST["program"] == "add-new") {
    $program = new \DataLoader\CACPrograms($_POST["newProgramName"], $_POST["newProgramTopic"], $_POST["newProgramOutreach"], $_POST["newProgramNotes"]);
    try {
        $program->createEntry($db);
        $programAdded = true;
    } catch (Exception $e) {
        echo("Uh oh, something went wrong");
    }
} else if ($_POST["program"] == "null") {
    die();
} else {
    $program = new \DataLoader\CACPrograms($_POST["newProgramName"], $_POST["newProgramTopic"], $_POST["newProgramOutreach"], $_POST["newProgramNotes"], $_POST["program"]);
}
if ($_POST["facility"] == "add-new") {
    $facility = new \DataLoader\CACFacility($_POST["newFacilityName"]);
    try {
        $facility->createEntry($db);
        $facilityAdded = true;
    } catch (Exception $e) {
        echo("Uh oh, something went wrong");
    }
} else if ($_POST["facility"] == "null") {
    die();
} else {
    $facility = new \DataLoader\CACFacility($_POST["newFacilityName"], null, null, $_POST["facility"]);
}
if ($_POST["fundingSource"] == "add-new") {
    $funding = new \DataLoader\CACFunding($_POST["newFundingSourceName"], $_POST["newFundingSourceType"]);
    try {
        $funding->createEntry($db);
        $fundingAdded = true;
    } catch (Exception $e) {
        echo("Uh oh, something went wrong");
    }
} else if ($_POST["fundingSource"] == "null") {
    die();
} else {
    $funding = new \DataLoader\CACFunding($_POST["newFundingSourceName"], $_POST["newFundingSourceType"], null, null, null, $_POST["fundingSource"]);
}

$event = new \DataLoader\CACEvent($_POST["eventType"], $program->get_id(), $_POST["eventDate"], $_POST["eventDate"]);
$event->createEntry($db);
$eventFacility = new \DataLoader\CACEventFacility($event->get_eventID(), $facility->get_id(), $funding->get_id(), $_POST["eventTotalChild"], $_POST["eventTotalAdult"], $_POST["eventTotalSenior"], $_POST["eventNotes"]);
$eventFacility->createEntry($db);
header("Location: ../index.php");

