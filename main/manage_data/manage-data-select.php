<?php
require_once('../_classes/DataLoader.php');
require_once('../../_libs/Template.php');

$pathArr = [
    "../index.php"
];
$nameArr = [
    "Index"
];

$db = \DataLoader\DataHandler::connectToDB();
Template::showHeader("Manage Data", "../../");
?>
    <body>
    <?php
    Template::genNavBar($pathArr, $nameArr);
    ?>
    <h1>Review Data</h1>
    <?php
    if(isset($_GET["e"])){
        ?>
        <h3 class="error-msg"><?= $_GET["e"] ?></h3>
        <?php
    }
    ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="events-tab" data-toggle="tab" href="#events" role="tab"
               aria-controls="events" aria-selected="true">Events</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="programs-tab" data-toggle="tab" href="#programs" role="tab" aria-controls="programs"
               aria-selected="false">Programs</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="facilities-tab" data-toggle="tab" href="#facilities" role="tab"
               aria-controls="facilities" aria-selected="false">Facilities</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="funding-tab" data-toggle="tab" href="#funding" role="tab" aria-controls="funding"
               aria-selected="false">Funding</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="events-tab">
            <form action="manage-event.php" method="POST">
                <select name="selectEvent" id="selectEvent" onchange="loadEventDetails(id)" onload="showDiv(this)">
                    <option value="null">Select an event to view</option>
                    <?php
                    $event_query = $db->query("SELECT e.program_id, e.event_id, p.program_name, ef.facility_id, f.facility_name, e.date_start
                    FROM programs as p
                    INNER JOIN events as e ON e.program_id = p.program_id
                    INNER JOIN events_facilities as ef ON ef.event_id = e.event_id
                    INNER JOIN facilities as f ON f.facility_id = ef.facility_id
                    ORDER BY date_start, facility_id DESC");
                    while ($event = $event_query->fetch()) {
                        ?>
                        <option value="<?php echo $event['program_id'] . '-' . $event['facility_id'] . '-' . $event['event_id'] ?>"><?php echo $event['program_name'] . ' - ' . $event['facility_name'] . ' - ' . $event['date_start'] ?></option>
                        <?php
                    }
                    ?>
                </select><br>
                <input name="mode" id="mode" value="view" hidden>
                <button type="submit" class="btn btn-primary">View</button>
            </form>
        </div>
        <div class="tab-pane fade" id="programs" role="tabpanel" aria-labelledby="programs-tab">
            <form action="manage-program.php" method="POST">
                <select name="selectProgram" id="selectProgram" onchange="loadProgramDetails(id)"
                        onload="showDiv(this)">
                    <option value="null">Select a program to view</option>
                    <?php
                    $programs_query = $db->query("SELECT program_id, program_name FROM programs");
                    while ($program = $programs_query->fetch()) {
                        ?>
                        <option value="<?= $program['program_id'] ?>"><?= $program['program_name'] ?></option>
                        <?php
                    }
                    ?>
                </select><br>
                <input name="mode" id="mode" value="view" hidden>
                <button type="submit" class="btn btn-primary">View</button>
            </form>
        </div>
        <div class="tab-pane fade" id="facilities" role="tabpanel" aria-labelledby="facilities-tab">
            <form action="manage-facility.php" method="POST">
                <select name="selectFacility" id="selectFacility" onchange="loadFacilityDetails(id)"
                        onload="showDiv(this)">
                    <option value="null">Select a facility to view</option>
                    <?php
                    $facilities_query = $db->query("SELECT facility_id, facility_name FROM facilities");
                    while ($facility = $facilities_query->fetch()) {
                        ?>
                        <option value="<?= $facility['facility_id'] ?>"><?= $facility['facility_name'] ?></option>
                        <?php
                    }
                    ?>
                </select><br>
                <input name="mode" id="mode" value="view" hidden>
                <button type="submit" class="btn btn-primary">View</button>
            </form>
        </div>
        <div class="tab-pane fade" id="funding" role="tabpanel" aria-labelledby="funding-tab">
            <form action="manage-funding.php" method="POST">
                <select name="selectFunding" id="selectFunding" onchange="loadFundingDetails(id)"
                        onload="showDiv(this)">
                    <option value="null">Select a funding source to view</option>
                    <?php
                    $funding_query = $db->query("SELECT funding_id, funding_name FROM funding");
                    while ($funding = $funding_query->fetch()) {
                        ?>
                        <option value="<?= $funding['funding_id'] ?>"><?= $funding['funding_name'] ?></option>
                        <?php
                    }
                    ?>
                </select><br>
                <input name="mode" id="mode" value="view" hidden>
                <button type="submit" class="btn btn-primary">View</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script>
    </body>
<?php
Template::showFooter();