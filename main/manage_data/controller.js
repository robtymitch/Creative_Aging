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
