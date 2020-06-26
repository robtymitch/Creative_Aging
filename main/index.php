<?php
require_once '../_libs/Template.php';
Template::showHeader("Index", "../");
?>

<body class="background">
    <nav class="navbar navbar-expand-lg navbar-dark navDesign" style="background-color: #343a40 ">
        <a class="navbar-brand " type="image/gif"><img src="../_assets/img/caclogo.png" class="img" style="height:70px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Create Event</a>
                </li>
            </ul>
        </div>
    </nav><br /><br />

    <div class="index-box b-test container">
        <a class="btn btn-primary col" href="add_data/add_data.php">Add New</a><br />
        <br class="">
        <a class="btn btn-primary col" href="manage_data/manage-data-select.php">Manage Data</a><br />
        <br class="">
        <a class="btn btn-primary col" href="pending_data/pending.php">Manage Pending Data</a><br />
        <br class="">
        <a class="btn btn-secondary col" href="report/report_generate.php">Generate Report</a><br />
    </div>

</body>
<div class="footer lastColor">
    <div class="wrap ">
        Copyright &copy; 2020 Code Rangers
    </div>
</div>
<?php
Template::showFooter();
