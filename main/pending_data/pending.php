<?php
require_once("../../_libs/Template.php");


Template::showHeader("Pending Data", "../../");

?>

    <body>

    <div class="container-fluid">
        <a href="..">Home</a>
        <div id="pending-container" class="row border-buffer">

            <div id="pending-list-area" class="col-3 scroll-box"></div>
            <div id="pending-entry-area" class="col">

                <h3 class="row">Entry Info</h3>
                <hr class="row">

                <div id="pending-details" class="row">
                    <div class="col-6">
                        <h4 class="row">Details</h4>
                        <hr class="row">
                        <h5 id="d-ev" class="row">Event:</h5>
                        <h5 id="d-fa" class="row">Facility:</h5>
                        <h5 id="d-fu" class="row">Funding:</h5>
                    </div>
                        <!--TODO: Display queried information, switch between views-->
                    <div class="col-6">
                        <h4 class="row">Attendees</h4>
                        <hr class="row">
                        <h5 id="a-ch" class="row">Children</h5>   <!-- a-ch == Attendee Children -->
                        <h5 id="a-ad" class="row">Adults</h5>     <!-- a-ad == Attendee Adults -->
                        <h5 id="a-se" class="row">Seniors</h5>    <!-- a-se == Attendee Seniors -->
                    </div>
                </div>
                <div class="row" style="float: right">
                    <span><button type="button" class="btn btn-warning" onclick="editMode()">Edit</button></span>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal finalization popup -->
    <div id="finalize-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="finalize-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <h6>Attendees</h6>
                        <label for="m-a-ch">Children</label>
                        <input id="m-a-ch" type="number" min="0">
                        <br>
                        <label for="m-a-ad">Adults</label>
                        <input id="m-a-ad" type="number" min="0">
                        <br>
                        <label for="m-a-se">Seniors</label>
                        <input id="m-a-se" type="number" min="0">
                        <br>
                        <label for="pending-check">No Longer Pending?</label>
                        <input id="pending-check" type="checkbox">
                        <br>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="editCommit()">Commit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script src="controller.js"></script>
    <script src="../../_assets/js/jquery-3.5.1.js"></script>
    <script src="../../_assets/js/bootstrap.js"></script>
    </body>

<?php

Template::showFooter();
