<?php
require_once('../_classes/DataLoader.php');
require_once('../../_libs/Template.php');

if(isset($_POST["selectProgram"])){
    if($_POST["selectProgram"] == "null"){
        $err = "No program has been selected!";
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
$id = $_POST['selectProgram'];
$pdo = \DataLoader\DataHandler::connectToDB();
$query = $pdo->prepare('SELECT program_name, program_topic FROM programs WHERE program_id = ?');
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
Template::showHeader("Manage Programs", "../../");
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
<h1>Review Program Data</h1>
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
                <p>' . $data['program_name'] . '</p>
                <h5>Program Topic</h5>
                <p>' . $data['program_topic'] . '</p>
                <form action="manage-program.php" method="POST">
                    <input name="mode" id="mode" value="edit" hidden> 
                    <input name="selectProgram" id="selectProgram" value="' . $id . '" hidden>
                    <input name="program_name" id="program_name" value="' . $data['program_name'] . '" hidden> 
                    <input name="program_topic" id="program_topic" value="' . $data['program_topic'] . '" hidden> 
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
                <form id="edit-form" action="manage-program.php" method="POST">
                    <h5>Title</h5>
                    <input type="text" name="program_name" id="program_name" value="' . $data['program_name'] . '"></br></br>
                    <h5>Program Topic</h5>
                    <select name="program_topic" id="program_topic">
                        <option value="music"' . isSelected("music", $data['program_topic']) . '>Music</option>
                        <option value="art"' . isSelected("art", $data['program_topic']) . '>Art</option>
                        <option value="wellness"' . isSelected("wellness", $data['program_topic']) . '>Wellness</option>
                        <option value="drama"' . isSelected("drama", $data['program_topic']) . '>Drama</option>
                        <option value="history-culture"' . isSelected("history-culture", $data['program_topic']) . '>History/Culture</option>
                    </select></br></br>
                    <input name="mode" id="mode" value="" type="hidden"> 
                    <input name="selectProgram" id="selectProgram" value="' . $id . '" hidden>
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
                <p>' . $_POST['program_name'] . '</p>
                <h5>Program Topic</h5>
                <p>' . $_POST['program_topic'] . '</p>
              </div>
            </div>';
    $data = new \DataLoader\CACPrograms($_POST['program_name'], $_POST['program_topic'], '', '', $_POST['selectProgram']);
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

