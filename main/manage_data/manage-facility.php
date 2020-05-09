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
    echo '<div class="card" style="width: 80%;">
            <div class="card-body">
                <form action="manage-facility.php" method="POST">
                    <h5>Title</h5>
                    <input type="text" name="facility_name" id="facility_name" value="' . $data['facility_name'] . '"></br></br>
                    </br>
                    <input name="mode" id="mode" value="update" hidden> 
                    <input name="selectFacility" id="selectFacility" value="' . $id . '" hidden>
                    <button type="submit" formmethod="post" class="btn btn-light">Submit</button>
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