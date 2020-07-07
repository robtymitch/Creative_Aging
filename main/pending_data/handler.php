<?php
require_once("../_classes/DataLoader.php");

define("KEY_FIELD_EVENT_TYPE", 0);
define("KEY_FIELD_FACILITY_NAME", 1);
define("KEY_FIELD_FUNDING_NAME", 2);
define("NOT_PENDING", 0);
define("IS_PENDING", 1);






$db = \DataLoader\DataHandler::connectToDB();

if (isset($_REQUEST["token"])) {
    $token = $_REQUEST["token"];
    $pending_query = "";
    $result_arr = [];
    switch ($token) {
        case "load":
        {
            $pending_query = "SELECT * FROM events_facilities WHERE pending=1";
            $query = $db->query($pending_query);
            while ($entry = $query->fetch()) {
                array_push($result_arr, $entry);
            }
            echo json_encode($result_arr);
            break;
        }
        case "fetch":
        {
            $pending_query = "SELECT * FROM events_facilities WHERE ef_id=" . $_REQUEST['id'];
            $query = $db->query($pending_query);
            while ($entry = $query->fetch()) {
                $result_arr = $entry;
            }
            $detail_queries = [
                "SELECT event_type FROM events WHERE event_id=" . $result_arr['event_id'],
                "SELECT facility_name FROM facilities WHERE facility_id=" . $result_arr['facility_id'],
                "SELECT funding_name FROM funding WHERE funding_id=" . $result_arr['funding_id']
            ];
            for ($i = 0; $i < count($detail_queries); $i++) {
                $query = $db->query($detail_queries[$i]);
                $entry = $query->fetch();
                $key = "";
                switch ($i) {
                    case KEY_FIELD_EVENT_TYPE:
                    {
                        $key = 'event_type';
                        break;
                    }
                    case KEY_FIELD_FACILITY_NAME:
                    {
                        $key = 'facility_name';
                        break;
                    }
                    case KEY_FIELD_FUNDING_NAME:
                    {
                        $key = 'funding_name';
                        break;
                    }
                }
                array_push($result_arr, $entry[$key]);
            }
            echo json_encode($result_arr);
            break;
        }
        case "commit":{
            $pending_query = "UPDATE events_facilities SET num_children=?, num_adults=?, num_seniors=?, pending=? WHERE ef_id=?";
            $query = $db->prepare($pending_query);
            $query->execute([$_REQUEST['attChildren'], $_REQUEST['attAdults'], $_REQUEST['attSeniors'], (($_REQUEST['pendingCheck'] == "true") ? NOT_PENDING : IS_PENDING), $_REQUEST['id']]);
        }
        default:
    }
}



