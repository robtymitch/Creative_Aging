<?php
require_once("../_classes/DataLoader.php");
require_once("../../_libs/Template.php");
session_start();
Template::showHeader("View Report", "../../");
$report = $_SESSION["report"];
$total_attendees = $_SESSION["report-attendee-total"];
$_SESSION = [];
session_destroy();
?>
    <script>
        let reportEntries = <?= json_encode($report) ?>;
        let reportAttendees = <?= json_encode($total_attendees) ?>;
    </script>
<?php

?>
    <body class="container main-bg-c">
    <?php
    Template::genNavBar(
        [
            "../index.php",
            "report_generate.php"
        ]
        ,
        [
            "Index",
            "Generate a new report"
        ]
    );

    //    echo(count($_SESSION["report"]));
    //    echo("<br>");
    //    echo(count($_SESSION["report"][0]));
    //    print_r($_SESSION["report"]);
    if ($report != null) {
        ?>
        <table class="table table-custom">
            <tr class="table-head">
                <th class="table-col-r">Total Attendees</th>
                <th class="table-col-r">Total Children</th>
                <th class="table-col-r">Total Adults</th>
                <th class="table-col-r">Total Seniors</th>
            </tr>
            <tr class="table-alt-0 table-row">
                <th class="table-col-r"><?= $total_attendees[0]["temp_total"] ?></th>
                <th class="table-col-r"><?= $total_attendees[0]["total_children"] ?></th>
                <th class="table-col-r"><?= $total_attendees[0]["total_adults"] ?></th>
                <th class="table-col-r"><?= $total_attendees[0]["total_seniors"] ?></th>
            </tr>
        </table>
        <br>
        <table class="table table-custom">
            <tr class="table-head">
                <th class="table-col-r">Program</th>
                <th class="table-col-r">Topic</th>
                <th class="table-col-r">Start Date</th>
                <th class="table-col-r">End Date</th>
                <th class="table-col-r">Facility</th>
                <th class="table-col-r">Total Attendees</th>
                <th class="table-col-r">Children Attendees</th>
                <th class="table-col-r">Adult Attendees</th>
                <th class="table-col-r">Senior Attendees</th>
                <th class="table-col-r">Funding Source</th>
            </tr>
            <?php
            for ($i = 0; $i < count($report); $i++) {
                if ($i % 2 == 0) {
                    ?>
                    <tr class="table-alt-0 table-row">
                    <?php
                } else {
                    ?>
                    <tr class="table-alt-1 table-row">
                    <?php
                }
                ?>
                <th class="table-col-r"><?= $report[$i]["program_name"] ?></th>
                <th class="table-col-r"><?= $report[$i]["program_topic"] ?></th>
                <th class="table-col-r"><?= $report[$i]["date_start"] ?></th>
                <th class="table-col-r"><?= $report[$i]["date_end"] ?></th>
                <th class="table-col-r"><?= $report[$i]["facility_name"] ?></th>
                <th class="table-col-r"><?= $report[$i]["total_attendees"] ?></th>
                <th class="table-col-r"><?= $report[$i]["num_children"] ?></th>
                <th class="table-col-r"><?= $report[$i]["num_adults"] ?></th>
                <th class="table-col-r"><?= $report[$i]["num_seniors"] ?></th>
                <th class="table-col-r"><?= $report[$i]["funding_name"] ?></th>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <button type="button" class="btn btn-primary" onclick="requestPDF()">Download PDF</button>


        <?php
    } else {
        ?>
        <h3>No.</h3>
        <?php
    }
    ?>
    <script src="../../_assets/js/jquery-3.5.1.js"></script>
    <script src="../../_assets/js/bootstrap.min.js"></script>
    <script src="controller-r.js"></script>
    </body>
<?php
Template::showFooter();
