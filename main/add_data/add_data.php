<?php
require_once '../../_libs/Template.php';
require_once '../_classes/DataLoader.php';
$db = \DataLoader\DataHandler::connectToDB();
Template::showHeader("Add Data", "../../");
?>
<body>
<?php
Template::genNavBar(
    [
        "../index.php"
    ]
    ,
    [
        "Index"
    ]
);
?>
    <form method="POST" action="submission_processing.php"> <!--Needs action attr.-->
        <label for="eventType">Event Type: </label>
        <select id="eventType" name="eventType">
            <option value="null">- Select an option -</option>
            <option value="scp">Senior Community Program</option>
            <option value="kohler">Kohler 1-on-1</option>
            <option value="outreach">Outreach</option>
        </select> <br><br>
        <label for="program">Program: </label>
        <select name="program" id="program" onchange="showDiv(this)" onload="showDiv(this)">
            <option value="null">- Select an option -</option>
            <option value="add-new">++ Add a new Program ++</option>
            <?php
            $programs_query = $db->query("SELECT program_id, program_name FROM programs");
            while($program = $programs_query->fetch()){
                ?>
                <option value="<?= $program['program_id'] ?>"><?= $program['program_name'] ?></option>
                <?php
            }
            ?>
            <!-- These select options should be dynamically pulled from the DB -->
        </select><br>
        <div id="program_hidden_div" class="hidden_div">
            <fieldset>
                <legend>Add a new program:</legend>
                <label for="newProgramName">Program Name: </label>
                <input type="text" name="newProgramName" id="newProgramName"><br>
                <label for="newProgramTopic">Program Topic: </label>
                <select name="newProgramTopic" id="newProgramTopic">
                    <option value="null">Select a program topic</option>
                    <option value="music">Music</option>
                    <option value="art">Art</option>
                    <option value="wellness">Wellness</option>
                    <option value="drama">Drama</option>
                    <option value="history-culture">History/Culture</option>
                </select><br>
                <label for="newProgramOutreach">Is this an Outreach Program? </label>
                <label for="newOutreachYes">Yes</label>
                <input type="radio" name="newProgramOutreach" id="newOutreachYes" value="yes">
                <label for="newOutreachNo">No</label>
                <input type="radio" name="newProgramOutreach" id="newOutreachNo" value="no" checked="checked"><br>
                <label for="newProgramDescription">Description</label>
                <textarea id="newProgramDescription" name="newProgramDescription"></textarea><br>
                <label for="newProgramNotes">Program Notes: </label>
                <input type="text" name="newProgramNotes" id="newProgramNotes">
            </fieldset>
        </div>
        <br>
        <label for="facility">Facility: </label>
        <select name="facility" id="facility" onchange="showDiv(this)" onload="showDiv(this)">
            <option value="null">- Select an option -</option>
            <option value="add-new">++ Add a new Facility ++</option>
            <?php
            $facilities_query = $db->query("SELECT facility_id, facility_name FROM facilities");
            while($facility = $facilities_query->fetch()){
                ?>
                <option value="<?= $facility['facility_id'] ?>"><?= $facility['facility_name'] ?></option>
                <?php
            }
            ?>
            <!-- These select options should be dynamically pulled from the DB -->
        </select> <br>
        <div id="facility_hidden_div" class="hidden_div">
            <fieldset>
                <legend>Add a new facility:</legend>
                <label for="newFacilityName">Facility Name: </label>
                <input type="text" name="newFacilityName" id="newFacilityName"><br>
            </fieldset>
        </div>
        <br>
        <label for="fundingSource">Funding Source: </label>
        <select name="fundingSource" id="fundingSource" onchange="showDiv(this)" onload="showDiv(this)">
            <option value="null">- Select an option -</option>
            <option value="add-new">++ Add a new Funding Source ++</option>
            <?php
            $funding_query = $db->query("SELECT funding_id, funding_name FROM funding");
            while($funding = $funding_query->fetch()){
                ?>
                <option value="<?= $funding['funding_id'] ?>"><?= $funding['funding_name'] ?></option>
                <?php
            }
            ?>
            <!-- These select options should be dynamically pulled from the DB -->
        </select> <br>
        <div id="fundingSource_hidden_div" class="hidden_div">
            <fieldset>
                <legend>Add a new funding source:</legend>
                <p>Reminder: If a funding source is renewed from year to year, consider adding the year to the funding
                    source's name to distinguish it from prior years.</p>
                <label for="newFundingSourceName">Funding Source Name: </label>
                <input type="text" name="newFundingSourceName" id="newFundingSourceName"><br>
                <label for="newFundingSourceType">Funding Source Type: </label>
                <select name="newFundingSourceType" id="newFundingSourceType" onchange="showDiv(this)"
                        onload="showDiv(this)">
                    <option value="null">Select a funding source type</option>
                    <option value="grant">Grant</option>
                    <option value="scholarship">Scholarship</option>
                </select><br>
            </fieldset>
        </div>

        <br>
        <label for="eventDate">Event Date: </label>
        <input type="date" name="eventDate" id="eventDate"><br>
<!--        <label for="eventTotalAtt">Total Adult Attendees: </label>-->
<!--        <input type="number" id="eventTotalAtt" name="eventTotalAdult" min="0"><br>-->
<!--        <label for="eventTotalSenior">Total Senior Attendees: </label>-->
<!--        <input type="number" id="eventTotalSenior" name="eventTotalSenior" min="0"><br>-->
<!--        <label for="eventTotalChild">Total Child Attendees: </label>-->
<!--        <input type="number" id="eventTotalChild" name="eventTotalChild" min="0"><br>-->
<!--        <label for="eventNotes">Notes: </label><input type="text" name="eventNotes" id="eventNotes"><br>-->
        <br>
        <div>
            <button type="button" class="btn btn-primary" onclick="confirmEntry()">Submit</button>
        </div>
        <!-- Confirmation Modal -->
        <div id="confirm-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="finalize-modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                    </div>
                    <div id="check-message">Are you sure?</div>
                    <div class="modal-footer">
                        <input id="submit-entry" class="btn btn-primary" name="submission" type="submit" value="Submit">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetErrors()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

<?php

Template::addScript('../../_assets/js/jquery-3.5.1.js');
Template::addScript('../../_assets/js/bootstrap.js');
Template::addScript('controller_cd.js');
?>
</body>
<?php
Template::showFooter();