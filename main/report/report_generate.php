<!--Generate Report Ver. 0.2
Contributors:
    RJ Clark, Alex Christen
-->
<?php
require_once("../_classes/DataLoader.php");
$db = \DataLoader\DataHandler::connectToDB();

?>

<!doctype html>
<html lang="en">
<head>
    <title>Generate Report</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../_assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../_assets/css/cac_main.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hind:wght@600;700&family=Oswald:wght@700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@1,500&display=swap" rel="stylesheet">
    <script>
        function showDiv() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'block';
            } else document.getElementById('ifYes').style.display = 'none';
        }
    </script>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark navDesign" style="background-color: #343a40 ">
    <a class="navbar-brand " type="image/gif"><img src="../../_assets/img/caclogo.png" class="img" style="height:70px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Create Event</a>
            </li>
        </ul>
    </div>
</nav>
<div class="wrap background">
    <br/>
    <h1 class="h1 mainFont">Generate a report of data from events</h1>
    <br/>
    <h2 class="secondaryFont">Select options below:</h2>
    <form action="report_processing.php" method="POST">
        <!--Needs action attr.-->
        <h2><u>Date</u></h2>
        <!--Query events.date-->
        <fieldset>
            <legend>Select a date range:</legend>
            <input type="radio" id="allTime" name="dateOpt" value="allTime">
            <label for="allTime">All-time</label><br>
            <input type="radio" id="specRange" name="dateOpt" value="specRange" checked="checked">
            <label for="specRange">Specify a range:</label><br>
            <fieldset>
                <!--Some JavaScript can disable this when the "All-time" option is selected.-->
                <label for="startDate" class="thirdFont">Start Date:</label>
                <input type="date" name="startDate" id="startDate"><br>
                <label for="endDate" class="thirdFont">End Date:</label>
                <input type="date" name="endDate" id="endDate">
            </fieldset>
        </fieldset>
        <br/>
        <h2><u>Funding Source</u></h2>
        <!--Query events_facilities.fundingID (maybe)-->
        <fieldset>
            <legend>Select a funding source:</legend>
            <input type="radio" id="allFundingSources" name="fundingOpt" value="allFundingSources" checked="checked">
            <label for="allFundingSources">All funding sources</label><br>
            <input type="radio" id="specFundingSource" name="fundingOpt" value="specFundingSource">
            <label for="specFundingSource">Specify a funding source</label><br>
            <label for="fundingType" class="thirdFont">First select a funding type : </label>
            <input list="fundingTypes" name="fundingType" id="fundingType">
            <!--Some JavaScript can disable this when the "All-time" option is selected.-->
            <datalist id="fundingTypes">
                <option value="Facility Paid">
                <option value="Scholarship">
                <option value="Grant">
                <option value="Sample Trial">
            </datalist>
            <br>
            <label for="fundingSources" class="thirdFont">Then, select a funding source:</label>
            <input list="fundingSources" name="fundingSource" id="fundingSource">
            <!--Some JavaScript can change the next datalist based on which funding type is chosen above. That way it only queries the DB for the type it need. Eg. Only query grant sources if the above funding type is "Grants"
        Otherwise I guess it just pulls *all* of the funding sources. Which is pretty unwieldy.-->
            <datalist id="fundingSources">
                <?php
                $funding_query = $db->query("SELECT funding_id, funding_name FROM funding");
                while ($funding = $funding_query->fetch()) {
                    ?>
                    <option value="<?= $funding['funding_name'] ?>"><?= $funding['funding_name'] ?></option>
                    <?php
                }
                ?>
                <!-- These datalist options should be dynamically pulled from the DB -->
            </datalist>
            <br>
        </fieldset>
        <br/>
        <h2><u>Facility</u></h2>
        <!--Query events_facilities.facilityID-->
        <fieldset>
            <legend>Select a facility:</legend>
            <input type="radio" id="allFacilities" name="facilityOpt" value="allFacilities" checked="checked">
            <label for="allFacilities">All facilities</label><br>
            <input type="radio" id="specFacility" name="facilityOpt" value="specFacility">
            <label for="specFacility">Select a facility</label><br>
            <label for="facilities">Facilities:</label>
            <input list="facilities" name="facility" id="facility">
            <!--Some JavaScript can disable this when the "All-time" option is selected.-->
            <datalist id="facilities">
                <?php
                $facilities_query = $db->query("SELECT facility_id, facility_name FROM facilities");
                while ($facility = $facilities_query->fetch()) {
                    ?>
                    <option value="<?= $facility['facility_name'] ?>"><?= $facility['facility_name'] ?></option>
                    <?php
                }
                ?>
            </datalist>
            <br>
        </fieldset>
        <br/>
        <h2><u>Program Type</u></h2>
        <!--Query programs.programType-->
        <fieldset>
            <legend>Select a program type:</legend>
            <input type="radio" id="allProgramTypes" name="programTypeOpt" value="allProgramTypes" checked="checked">
            <label for="allProgramTypes">All program types</label><br>
            <input type="radio" id="specProgramType" name="programTypeOpt" value="specProgramType">
            <label for="specProgramType">Select a program type</label><br>
            <label for="programTypes" class="thirdFont">Program Types:</label>
            <input list="programTypes" name="programType" id="programType">
            <!--Some JavaScript can disable this when the "All-time" option is selected.-->
            <datalist id="programTypes">
                <option value="Senior Community Program">
                <option value="Kohler 1-on-1's">
                <option value="Outreach">
            </datalist>
            <br>
        </fieldset>
        <br/>
        <h2><u>Program Topic</u></h2>
        <!--Query programs.programTopic-->
        <fieldset>
            <legend>Select a program topic:</legend>
            <input type="radio" id="allProgramTopics" name="programTopicOpt" value="allProgramTopics" checked="checked">
            <label for="allProgramTopic">All program topics</label><br>
            <input type="radio" id="specProgramTopic" name="programTopicOpt" value="specProgramTopic">
            <label for="specProgramTopic">Select a program topic</label><br>
            <label for="programTopics" class="thirdFont">Program Topics:</label>
            <input list="programTopics" name="programTopic" id="programTopic">
            <!--Some JavaScript can disable this when the "All-time" option is selected.-->
            <datalist id="programTopics">
                <option value="Music">
                <option value="Art">
                <option value="Wellness">
                <option value="Drama">
                <option value="History/Culture">
            </datalist>
            <br>
        </fieldset>
        <br/>
        <label for="submit-report"></label>
        <input type="hidden" name="form-submitted" value="1">
        <input id="submit-report" type="submit" class="btn btn-warning thirdFont" value="Generate Report">
    </form>
    <br/>
</div>
<div class="lastFooter lastColor">
    <div class="wrap ">
        Copyright &copy; 2020 Code Rangers
    </div>

</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../_assets/js/jquery-3.5.1.js"></script>
<script src="../../_assets/js/bootstrap.min.js"></script>

</body>

</html>