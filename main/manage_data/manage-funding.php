<?php
require_once('../_classes/DataLoader.php');
require_once('../../_libs/Template.php');
if(isset($_POST["selectFunding"])){
    if($_POST["selectFunding"] == "null"){
        $err = "No funding has been selected!";
        header("Location: manage-data-select.php?e=".$err);
    }
}
else{
    header("Location: manage-data-select.php");
}
?>
    <script>
        let mode = "unset";
    </script>
<?php
$id = $_POST['selectFunding'];
$pdo = \DataLoader\DataHandler::connectToDB();
$query = $pdo->prepare('SELECT funding_name, funding_type FROM funding WHERE funding_id = ?');
$query->execute([$id]);
$data = [];
$row = $query->fetch();
$col_names = array_keys($row);
foreach ($col_names as $column) {
    $data[$column] = $row[$column];
}
function isSelected($value, $option)
{
    if ($value == $option) return 'selected="selected"';
    else return '';
}
Template::showHeader("Manage Funding", "../../");
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
<h1>Review Funding Source Data</h1>
<?php
if ($_POST['mode'] == 'view') {
    ?>
    <script>
        mode = "view";
    </script>
    <?php
    echo '<div class="card" style="width: 80%;">
            <div class="card-body">
                <h5>Funding Source Name</h5>
                <p>' . $data['funding_name'] . '</p>
                <h5>Funding Source Type</h5>
                <p>' . $data['funding_type'] . '</p>
                <form action="manage-funding.php" method="POST">
                    <input name="mode" id="mode" value="edit" hidden> 
                    <input name="selectFunding" id="selectFunding" value="' . $id . '" hidden>
                    <input name="funding_name" id="funding_name" value="' . $data['funding_name'] . '" hidden> 
                    <input name="funding_type" id="funding_type" value="' . $data['funding_type'] . '" hidden> 
                    <button type="submit" formmethod="post" class="btn btn-light">Edit</button>
                </form>
              </div>
            </div>';
}
if ($_POST['mode'] == 'edit') {
    ?>
    <script>
        mode = "edit";
    </script>
    <?php
    echo '<div class="card" style="width: 80%;">
            <div class="card-body">
                <form id="edit-form" action="manage-funding.php" method="POST">
                    <h5>Funding Source Name</h5>
                    <input type="text" name="funding_name" id="funding_name" value="' . $data['funding_name'] . '"></br></br>
                    <h5>Funding Source Type</h5>
                    <select name="funding_type" id="funding_type">
                        <option value="grant" ' . isSelected("grant", $data['funding_type']) . '>Grant</option>
                        <option value="Scholarship" ' . isSelected("scholarship", $data['funding_type']) . '>Scholarship</option>
                    </select></br></br>
                    <input name="mode" id="mode" value="" type="hidden"> 
                    <input name="selectFunding" id="selectFunding" value="' . $id . '" type="hidden">
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
                <h5>Funding Source Name</h5>
                <p>' . $_POST['funding_name'] . '</p>
                <h5>Funding Source Type</h5>
                <p>' . $_POST['funding_type'] . '</p>
              </div>
            </div>';
    $data = new \DataLoader\CACFunding($_POST['funding_name'], $_POST['funding_type'], '', '', '', $_POST['selectFunding']);
    $database = \DataLoader\DataHandler::connectToDB();
    $data->updateEntry($database);
}
?>

<script src="../../_assets/js/jquery-3.5.1.js"></script>
<script src="../../_assets/js/bootstrap.min.js"></script>
<script src="controller.js"></script>
</body>


<?php
Template::showFooter();