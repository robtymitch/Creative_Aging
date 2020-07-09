
/*--Error Constants--*/
//No selection error messages
const ERROR_NO_EVENT_TYPE_SELECTED = "No event type selected";
const ERROR_NO_PROGRAM_SELECTED = "No program selected";
const ERROR_NO_FACILITY_SELECTED = "No facility selected";
const ERROR_NO_FUNDING_SELECTED = "No funding source selected";
const ERROR_NO_DATE_SELECTED = "No date was selected";
//program errors
const ERROR_PROGRAM_NO_NAME = "No program name given";
const ERROR_PROGRAM_NO_TOPIC = "No program topic selected";
//facility errors
const ERROR_FACILITY_NO_NAME = "No facility name given";
//funding errors
const ERROR_FUNDING_NO_NAME = "No funding name given";
const ERROR_FUNDING_NO_TYPE = "No funding type selected";
/*----*/
const CONFIRMATION_MESSAGE = "Ready to commit?";
//CSS Constants
const SELECTION_WARNING = 'selection-warning';
//Form submit variable
let submitEntryButton = document.getElementById("submit-entry");
//Selects
let checkMessage = document.getElementById("check-message");
let selectEventType = document.getElementById("eventType");
let selectProgram = document.getElementById("program");
let selectFacility = document.getElementById("facility");
let selectFunding = document.getElementById("fundingSource");
let eventDate = document.getElementById("eventDate");

let selectionErrorPresent = false;
let selectionErrors = [];

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
    switch(selectEventType.value){
        case "null":{
            selectionErrorPresent = true;
            selectionErrors.push(ERROR_NO_EVENT_TYPE_SELECTED);
            selectEventType.classList.add('selection-warning');
            break;
        }
        default:
    }
    switch(selectProgram.value){
        case "null":{
            selectionErrorPresent = true;
            selectionErrors.push(ERROR_NO_PROGRAM_SELECTED);
            selectProgram.classList.add(SELECTION_WARNING);
            break;
        }
        case "add-new":{
            programCheck();
            break;
        }
    }
    switch(selectFacility.value){
        case "null":{
            selectionErrorPresent = true;
            selectionErrors.push(ERROR_NO_FACILITY_SELECTED);
            selectFacility.classList.add(SELECTION_WARNING);
            break;
        }
        case "add-new":{
            facilityCheck();
            break;
        }
    }
    switch(selectFunding.value){
        case "null":{
            selectionErrorPresent = true;
            selectionErrors.push(ERROR_NO_FUNDING_SELECTED);
            selectFunding.classList.add(SELECTION_WARNING);
            break;
        }
        case "add-new":{
            fundingCheck();
            break;
        }
    }

    if(eventDate.value === ""){
        selectionErrorPresent = true;
        selectionErrors.push(ERROR_NO_DATE_SELECTED);
        eventDate.classList.add(SELECTION_WARNING);
    }

}

function programCheck(){
    let programName = document.getElementById("newProgramName");
    let programTopic = document.getElementById("newProgramTopic");
    if(programName.value.trim() === ""){
        selectionErrorPresent = true;
        selectionErrors.push(ERROR_PROGRAM_NO_NAME);
        programName.classList.add(SELECTION_WARNING);
    }
    if(programTopic.value === "null"){
        selectionErrorPresent = true;
        selectionErrors.push(ERROR_PROGRAM_NO_TOPIC);
        programTopic.classList.add(SELECTION_WARNING);
    }
}
function facilityCheck(){
    let facilityName = document.getElementById("newFacilityName");
    if(facilityName.value.trim() === ""){
        selectionErrorPresent = true;
        selectionErrors.push(ERROR_FACILITY_NO_NAME);
        facilityName.classList.add(SELECTION_WARNING);
    }
}
function fundingCheck(){
    let fundingName = document.getElementById("newFundingSourceName");
    let fundingType = document.getElementById("newFundingSourceType");
    if(fundingName.value.trim() === ""){
        selectionErrorPresent = true;
        selectionErrors.push(ERROR_FUNDING_NO_NAME);
        fundingName.classList.add(SELECTION_WARNING);
    }
    if(fundingType.value === "null"){
        selectionErrorPresent = true;
        selectionErrors.push(ERROR_FUNDING_NO_TYPE);
        fundingType.classList.add(SELECTION_WARNING);
    }
}
function displayError(item, index){
    checkMessage.innerHTML += "<div>" + item + "</div><br>";
}
function resetErrors(){
    submitEntryButton.disabled = false;
    selectionErrors = [];
}