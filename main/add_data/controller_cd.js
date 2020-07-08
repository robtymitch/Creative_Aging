const SELECT_EVENT_TYPE_ERROR = "No event type selected";
const SELECT_PROGRAM_ERROR = "No program selected";
const SELECT_FACILITY_ERROR = "No facility selected";
const SELECT_FUNDING_ERROR = "No funding source selected";
const CONFIRMATION_MESSAGE = "Ready to commit?";

let submitEntryButton = document.getElementById("submit-entry");
let checkMessage = document.getElementById("check-message");
let selectEventType = document.getElementById("eventType");
let selectProgram = document.getElementById("program");
let selectFacility = document.getElementById("facility");
let selectFunding = document.getElementById("fundingSource");

let selectionErrorPresent = false;
let selectionErrors = [];



showDiv();

function showDiv(select) {
    if (select.value === "add-new") {
        document.getElementById(select.name + '_hidden_div').style.display = "block";
    } else {
        document.getElementById(select.name + '_hidden_div').style.display = "none";
    }
}
function confirmEntry(){
    selectionErrorPresent = false;
    $('#confirm-modal').modal({backdrop: 'static', keyboard: false});
    selectCheck();
    if(selectionErrorPresent){
        submitEntryButton.disabled = true;

        checkMessage.innerHTML = "";
        checkMessage.innerText = "Unable to submit, following errors present: ";

        selectionErrors.forEach(displayError);
    } else {
        checkMessage = CONFIRMATION_MESSAGE;
    }
}
function selectCheck(){
    if(selectEventType.value === "null"){
        selectionErrorPresent = true;
        selectionErrors.push(SELECT_EVENT_TYPE_ERROR);
        selectEventType.classList.add('selection-warning');
    }
    if(selectProgram.value === "null"){
        selectionErrorPresent = true;
        selectionErrors.push(SELECT_PROGRAM_ERROR);
        selectProgram.classList.add('selection-warning');
    }
    if(selectFacility.value === "null"){
        selectionErrorPresent = true;
        selectionErrors.push(SELECT_FACILITY_ERROR);
        selectFacility.classList.add('selection-warning');
    }
    if(selectFunding.value === "null"){
        selectionErrorPresent = true;
        selectionErrors.push(SELECT_FUNDING_ERROR);
        selectFunding.classList.add('selection-warning');
    }
}
function displayError(item, index){
    checkMessage.innerHTML += "<div>" + item + "</div><br>";
}
function resetErrors(){
    submitEntryButton.disabled = false;
    selectionErrors = [];
}





