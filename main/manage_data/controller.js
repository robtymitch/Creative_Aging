const EDIT_MODE_UPDATE = "update";
const EDIT_MODE_CANCEL = "view";

let editForm;
let formMode;

if(mode === "edit"){
    editForm = document.getElementById("edit-form");
    formMode = document.getElementById("mode");
}
function eventDelete(){
    $('#confirm-modal').modal({backdrop: 'static', keyboard: false});
}
function editUpdate(){
    formMode.value = EDIT_MODE_UPDATE;
    editForm.submit();
}
function editCancel(){
    formMode.value = EDIT_MODE_CANCEL;
    editForm.reset();
    editForm.submit();
}

function selectAndCloseDropEvent(obj, name, id) {
        document.getElementById('selectEvent').value=id; 
        document.getElementById('eventInput').value=name;
        div = document.getElementById("eventDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            a[i].style.display = "none";
        }
}

function selectAndCloseDropProgram(obj, name, id) {
        document.getElementById('selectProgram').value=id; 
        document.getElementById('programInput').value=name;
        div = document.getElementById("programDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            a[i].style.display = "none";
        }
}

function selectAndCloseDropFacility(obj, name, id) {
        document.getElementById('selectFacility').value=id; 
        document.getElementById('facilityInput').value=name;
        div = document.getElementById("facilityDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            a[i].style.display = "none";
        }
}

function selectAndCloseDropFunding(obj, name, id) {
        document.getElementById('selectFunding').value=id; 
        document.getElementById('fundingInput').value=name;
        div = document.getElementById("fundingDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            a[i].style.display = "none";
        }
}
        
function filterDrop(type) {
  var input, filter, ul, li, a, i;
  input = document.getElementById(type + 'Input');
  filter = input.value.toUpperCase();
  div = document.getElementById(type + 'Dropdown');
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

