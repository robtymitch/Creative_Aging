<?php
require_once('../_classes/DataLoader.php');
require_once('../../_libs/Template.php');
?>
<script>
    let mode = "unset";
</script>
<?php
if (isset($_POST['selectEvent'])) {
    if($_POST["selectEvent"] == "null"){
        $err = "No event has been selected!";
        header("Location: manage-data-select.php?e=".$err);
    }

    if ($_POST['selectEvent'] == 'getNew'){
        $id = $_POST['program_id'] . '-' . $_POST['facility_id'] . '-' . $_POST['event_id'];
    }
    else $id = $_POST['selectEvent'];
    $pieces = explode("-", $id);
    $programID = $pieces[0];
    $facilityID = $pieces[1];
    $eventID = $pieces[2];
}
else{
    header("Location: manage-data-select.php");
}
$db = \DataLoader\DataHandler::connectToDB();

if(isset($_POST['delete'])){
    if($_POST['delete'] == 'Delete'){
        unset($_POST['delete']);
        $db->query('DELETE FROM events WHERE event_id=' . $eventID);
        header("Location: manage-data-select.php");
    }
}
if ($_POST['mode'] == 'view' || $_POST['mode'] == 'edit') {
    if($_POST['mode'] == 'edit'){
        ?>
        <script>
            mode = "edit";
        </script>
        <?php
    } else {
        ?><script>
            mode = "view";
        </script>
        <?php
    }
    $query = $db->prepare('SELECT e.event_id, e.event_type, e.program_id, p.program_name, ef.facility_id, f.facility_name, fun.funding_name, fun.funding_id, e.date_start, e.date_end, ef.num_children, ef.num_adults, ef.num_seniors, (ef.num_children + ef.num_adults + ef.num_seniors) as total_attendees
                        FROM programs as p
                        INNER JOIN events as e ON e.program_id = p.program_id
                        INNER JOIN events_facilities as ef ON ef.event_id = e.event_id
                        INNER JOIN facilities as f ON f.facility_id = ef.facility_id
                        INNER JOIN funding as fun ON fun.funding_id = ef.funding_id
                        WHERE e.program_id = ? AND ef.facility_id = ?');
    $query->execute([$programID, $facilityID]);
    $data = [];
    $row = $query->fetch();
    $col_names = array_keys($row);
    foreach ($col_names as $column) {
        $data[$column] = $row[$column];
    }
} elseif ($_POST['mode'] == 'update') {
    $data = [];
    $components = ["program" => "programs", "facility" => "facilities", "funding" => "funding"];
    foreach ($components as $key => $value) {
        $query = $db->prepare('SELECT ' . $key . '_id, ' . $key . '_name FROM ' . $value . ' WHERE ' . $key . '_id = ?');
        $query->execute([$_POST[$key . '_id']]);
        $row = $query->fetch();
        $col_names = array_keys($row);
        foreach ($col_names as $column) {
            $data[$column] = $row[$column];
        }
    }
    foreach ($_POST as $key => $value) {
        $data[$key] = $value;
    }
} else echo 'You did wrong. Go back and try again.';
function isSelected($value, $option)
{
    if ($value == $option) return 'selected="selected"';
    else return '';
}
Template::showHeader("Manage Event", "../../");
?>
<body>
<?php
Template::genNavBar(
    [
        "../index.php",
        "manage-data-select.php"
    ]
    ,
    [
        "Index",
        "Data Select"
    ]
);
?>
<h1>Review Event Data</h1>
<?php
if ($_POST['mode'] == 'view') {
    //TODO: Clean up
    echo '<div class="card" style="width: 80%;">
            <div class="card-body">
                <h5>Program Name</h5>
                <p>' . $data['program_name'] . '</p>
                <h5>Facility Name</h5>
                <p>' . $data['facility_name'] . '</p>
                <h5>Event Type</h5>
                <p>' . $data['event_type'] . '</p>
                <h5>Funding Source</h5>
                <p>' . $data['funding_name'] . '</p>
                <h5>Start Date</h5>
                <p>' . $data['date_start'] . '</p>
                <h5>End Date</h5>
                <p>' . $data['date_end'] . '</p>
                <h5>Total Number Attendees</h5>
                <p>' . $data['total_attendees'] . '</p>
                <h5>Number of Child Attendees</h5>
                <p>' . $data['num_children'] . '</p>
                <h5>Number of Adult Attendees</h5>
                <p>' . $data['num_adults'] . '</p>
                <h5>Number of Senior Attendees</h5>
                <p>' . $data['num_seniors'] . '</p>
                <form action="manage-event.php" method="POST">
                    <input name="mode" id="mode" value="edit" hidden> 
                    <input name="selectEvent" id="selectEvent" value="' . $id . '" hidden>
                    <input name="event_id" id="event_id" value="' . $data['event_id'] . '" hidden>
                    <input name="facility_id" id="facility_id" value="' . $data['facility_id'] . '" hidden>
                    <input name="funding_id" id="funding_id" value="' . $data['funding_id'] . '" hidden>
                    <input name="program_name" id="program_name" value="' . $data['program_name'] . '" hidden>
                    <input name="facility_name" id="facility_name" value="' . $data['facility_name'] . '" hidden>
                    <input name="event_type" id="event_type" value="' . $data['event_type'] . '" hidden>
                    <input name="funding_name" id="funding_name" value="' . $data['funding_name'] . '" hidden>
                    <input name="date_start" id="date_start" value="' . $data['date_start'] . '" hidden>
                    <input name="date_end" id="date_end" value="' . $data['date_end'] . '" hidden>
                    <input name="num_children" id="num_children" value="' . $data['num_children'] . '" hidden>
                    <input name="num_adults" id="num_adults" value="' . $data['num_adults'] . '" hidden>
                    <input name="num_seniors" id="num_seniors" value="' . $data['num_seniors'] . '" hidden>
                    <input name="total_attendees" id="total_attendees" value="' . $data['total_attendees'] . '" hidden>
                    <button type="submit" formmethod="post" class="btn btn-warning">Edit</button>
                    <button type="button" class="btn btn-danger" onclick="eventDelete()">Delete</button>
                    <!-- confirmation modal -->
                    <div id="confirm-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="finalize-modal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmation</h5>
                                </div>
                                <div>Are you sure?</div>
                                <div class="modal-footer">
                                    <input name="delete" type="submit" class="btn btn-danger" value="Delete">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
              </div>
            </div>';
}
if ($_POST['mode'] == 'edit') {
    echo '<div class="card" style="width: 80%;">
            <div class="card-body">
                <form id="edit-form" action="manage-event.php" method="POST">
                    <h5>Event Type</h5>
                    <select name="event_type" id="event_type">
                        <option value="scp"' . isSelected("scp", $data['event_type']) . '>Senior Community Program</option>
                        <option value="kohler"' . isSelected("kohler", $data['event_type']) . '>Kohler 1-on-1\'s</option>
                        <option value="outreach"' . isSelected("outreach", $data['event_type']) . '>Outreach</option>
                    </select></br></br>
                    <h5>Program</h5>
                    <select name="program_id" id="program_id">';
    $programs_query = $db->query("SELECT program_id, program_name FROM programs");
    while ($program = $programs_query->fetch()) {
        echo '<option value="' . $program['program_id'] . '" ' . isSelected($program['program_id'], $data['program_id']) . '>' . $program['program_name'] . '</option>';
    }
    echo '</select></br></br>
                    <h5>Facility</h5>
                    <select name="facility_id" id="facility_id">';
    $facilities_query = $db->query("SELECT facility_id, facility_name FROM facilities");
    while ($facility = $facilities_query->fetch()) {
        echo '<option value="' . $facility['facility_id'] . '" ' . isSelected($facility['facility_id'], $data['facility_id']) . '>' . $facility['facility_name'] . '</option>';
    }
    echo '</select></br></br>
                    <h5>Funding Source</h5>
                    <select name="funding_id" id="funding_id">';
    $funding_query = $db->query("SELECT funding_id, funding_name FROM funding");
    while ($funding = $funding_query->fetch()) {
        echo '<option value="' . $funding['funding_id'] . '" ' . isSelected($funding['funding_id'], $data['funding_id']) . '>' . $funding['funding_name'] . '</option>';
    }
    echo '</select></br></br>
                    <h5>Start Date</h5>
                    <input type="date" name="date_start" id ="date_start" value="' . $data['date_start'] . '"></br></br>
                    <h5>End Date</h5>
                    <input type="date" name="date_end" id ="date_end" value="' . $data['date_end'] . '"></br></br>
                    <h5>Total Child Attendees</h5>
                    <input type="number" name="num_children" id="num_children" value="' . $data['num_children'] . '" min=0></br></br>
                    <h5>Total Adult Attendees</h5>
                    <input type="number" name="num_adults" id="num_adults" value="' . $data['num_adults'] . '" min=0></br></br>
                    <h5>Total Senior Attendees</h5>
                    <input type="number" name="num_seniors" id="num_seniors" value="' . $data['num_seniors'] . '" min=0></br></br>
                    <input name="mode" id="mode" value="" type="hidden">';
    $id = 'getNew';
    echo '<input name="selectEvent" id="selectEvent" value="' . $id . '" hidden>
                    <input name="event_id" id="event_id" value="' . $data['event_id'] . '" hidden>
                    </br>
                    <button type="button"  class="btn btn-primary" onclick="editUpdate()">Submit</button>
                    <button type="button"  class="btn btn-secondary" onclick="editCancel()">Cancel</button>
                    
                </form>
              </div>
            </div>';
}
if ($_POST['mode'] == 'update') {
    echo '<div class="card" style="width: 80%;">
            <div class="card-body">
                <div class="alert alert-success" role="alert">
                  Data successfully updated!
                </div>
                <h5>Program Name</h5>
                <p>' . $data['program_name'] . '</p>
                <h5>Facility Name</h5>
                <p>' . $data['facility_name'] . '</p>
                <h5>Event Type</h5>
                <p>' . $data['event_type'] . '</p>
                <h5>Funding Source</h5>
                <p>' . $data['funding_name'] . '</p>
                <h5>Start Date</h5>
                <p>' . $data['date_start'] . '</p>
                <h5>End Date</h5>
                <p>' . $data['date_end'] . '</p>
                <h5>Total Number Attendees</h5>
                <p>' . ($data['num_children'] + $data['num_adults'] + $data['num_seniors']) . '</p>
                <h5>Number of Child Attendees</h5>
                <p>' . $data['num_children'] . '</p>
                <h5>Number of Adult Attendees</h5>
                <p>' . $data['num_adults'] . '</p>
                <h5>Number of Senior Attendees</h5>
                <p>' . $data['num_seniors'] . '</p>
              </div>
            </div>';
    $eventsInput = new \DataLoader\CACEvent($data['event_type'], $data['program_id'], $data['date_start'], $data['date_end'], $notes = null, $data['event_id']);
    $eventsInput->updateEntry($db);
    $eventsFacilitiesInput = new \DataLoader\CACEventFacility($data['event_id'], $data['facility_id'], $data['funding_id'], $data['num_children'], $data['num_adults'], $data['num_seniors'], $feedback = null);
    $eventsFacilitiesInput->updateEntry($db);
}
?>

<script src="../../_assets/js/jquery-3.5.1.js"></script>
<script src="../../_assets/js/bootstrap.min.js"></script>
<script src="controller.js"></script>
</body>
<?php
Template::showFooter();
