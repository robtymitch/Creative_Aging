showDiv();

function showDiv(select) {
    if (select.value === "add-new") {
        document.getElementById(select.name + '_hidden_div').style.display = "block";
    } else {
        document.getElementById(select.name + '_hidden_div').style.display = "none";
    }
}
