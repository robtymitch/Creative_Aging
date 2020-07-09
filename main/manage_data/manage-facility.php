<?php
require_once('../_classes/DataLoader.php');
require_once('../../_libs/Template.php');
if(isset($_POST["selectFacility"])){
    if($_POST["selectFacility"] == "null"){
        $err = "No facility has been selected!";
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
$id = $_POST['selectFacility'];
$pdo = \DataLoader\DataHandler::connectToDB();
$query = $pdo->prepare('SELECT facility_name FROM facilities WHERE facility_id = ?');
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
Template::showHeader("Manage Facilities", "../../");
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
<h1>Review Facility Data</h1>
<?php
if ($_POST['mode'] == 'view') {
    ?>
    <script>
        mode = "view";
    </script>
    <?php
    echo '<div class="card" style="width: 80%;">
            <div class="card-body">
                <h5>Title</h5>
                <p>' . $data['facility_name'] . '</p>
                <form action="manage-facility.php" method="POST">
                    <input name="mode" id="mode" value="edit" hidden> 
                    <input name="selectFacility" id="selectFacility" value="' . $id . '" hidden>
                    <input name="facility_name" id="faciltiy_name" value="' . $data['facility_name'] . '" hidden> 
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
                <form id="edit-form" action="manage-facility.php" method="POST">
                    <h5>Title</h5>
                    <input type="text" name="facility_name" id="facility_name" value="' . $data['facility_name'] . '"></br></br>
                    </br>
                    <input name="mode" id="mode" value="" type="hidden"> 
                    <input name="selectFacility" id="selectFacility" value="' . $id . '" hidden>
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
                <h5>Title</h5>
                <p>' . $_POST['facility_name'] . '</p>
              </div>
            </div>';
    $data = new \DataLoader\CACFacility($_POST['facility_name'], '', '', $_POST['selectFacility']);
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