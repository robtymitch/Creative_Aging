const KEY_FIELD_EVENT_TYPE = 0, KEY_FIELD_FACILITY_NAME = 1, KEY_FIELD_FUNDING_NAME = 2;


let pendingList = document.getElementById("pending-list-area");
let lastSelectedEntry = {
    ef_id: null,
    event_id: null,
    facility_id: null,
    funding_id: null,
    num_children: null,
    num_adults: null,
    num_seniors: null,
    feedback: null,
    date_created: null,
    pending: null,
    event_type: null,
    facility_name: null,
    funding_name: null
};
document.querySelector("#pending-list-area").addEventListener("click", displayEntry, false);
loadPending();




function loadPending(){
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            let pending_json = JSON.parse(this.responseText);
            for(let i = 0; i < pending_json.length; i++){
                formEntry(pending_json[i]);
            }
        }
    };
    request.open("GET", "handler.php?token=load", true);
    request.send();
}
function clearPending(){
    pendingList.innerHTML = "";
}

function formEntry(entry){
    pendingList.innerHTML += "<button id='e"+ entry.ef_id +"' class=''> Entry: " + entry.ef_id +"</button>";
}
function displayEntry(e){
    if(e.target !== e.currentTarget){
        //
        let entry = e.target;
        //details
        let detEvent = document.getElementById("d-ev");
        let detFacility = document.getElementById("d-fa");
        let detFunding = document.getElementById("d-fu");
        //attendees
        let attChildren = document.getElementById("a-ch");
        let attAdults = document.getElementById("a-ad");
        let attSeniors = document.getElementById("a-se");

        let id = entry.id;
        id = id.replace("e", "");

        let request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState === 4 && request.status === 200) {
                lastSelectedEntry = JSON.parse(request.responseText);
                lastSelectedEntry.event_type = lastSelectedEntry[KEY_FIELD_EVENT_TYPE];
                lastSelectedEntry.facility_name = lastSelectedEntry[KEY_FIELD_FACILITY_NAME];
                lastSelectedEntry.funding_name = lastSelectedEntry[KEY_FIELD_FUNDING_NAME];

            }
        };
        request.open("GET", "handler.php?token=fetch&id=" + id, false);
        request.send();
        detEvent.innerText    =    "Event: " + lastSelectedEntry.event_type;
        detFacility.innerText = "Facility: " + lastSelectedEntry.facility_name;
        detFunding.innerText  =  "Funding: " + lastSelectedEntry.funding_name;
        attChildren.innerText = "Children: " + lastSelectedEntry.num_children;
        attAdults.innerText   =   "Adults: " + lastSelectedEntry.num_adults;
        attSeniors.innerText  =  "Seniors: " + lastSelectedEntry.num_seniors;
    }
}

function editMode(){
    $('#finalize-modal').modal({backdrop: 'static', keyboard: false});
    $('#m-a-ch').val((lastSelectedEntry.num_children === null) ? 0 : lastSelectedEntry.num_children);
    $('#m-a-ad').val((  lastSelectedEntry.num_adults === null) ? 0 : lastSelectedEntry.num_adults  );
    $('#m-a-se').val(( lastSelectedEntry.num_seniors === null) ? 0 : lastSelectedEntry.num_seniors );
    $('#pending-check').prop('checked', false);
}
function editCommit(){

    let attChildren = $('#m-a-ch').val();
    let attAdults = $('#m-a-ad').val();
    let attSeniors = $('#m-a-se').val();
    let pendingCheck = $('#pending-check').is(":checked");


    console.log(attChildren + " | " + pendingCheck);


    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            //console.log(request.responseText);
        }
    };
    request.open("GET", "handler.php?token=commit&attChildren=" + attChildren + "&attAdults=" + attAdults + "&attSeniors=" + attSeniors + "&pendingCheck=" + pendingCheck + "&id=" + lastSelectedEntry.ef_id, false);
    request.send();

    clearPending();
    loadPending();
    $('#finalize-modal').modal('hide').modal('dispose');
}
function editCancel(){}


