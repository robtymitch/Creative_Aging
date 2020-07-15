const TEMP_DOWNLOAD_REL_PATH = "../../temp/";

let d = new Date();
let filename = "cac_report_" + (d.getMonth() + 1 )+ "_" + d.getDate() + "_" + d.getFullYear() + ".pdf";

function requestPDF(){
    console.log("<+|/ Request sent /|->");
    $.ajax({
        type: "POST",
        url: "download/report_download.php",
        data:{
            filename: filename,
            entries: reportEntries,
            attendees: reportAttendees
        },
        success: function(data){
            console.log("<-| Request processed |+>");
            console.log(data);
            downloadPDF();

        }
    });
}
function downloadPDF(){
    let aTag = document.createElement("a");
    aTag.href = TEMP_DOWNLOAD_REL_PATH + filename;
    aTag.download = filename;
    document.body.appendChild(aTag);
    aTag.click();
    setTimeout(function(){
        document.body.removeChild(aTag);
        flush();
    }, 0);
}
function flush(){ //triggers report_flush.php to clean out the temp folder
    $.ajax(
        {
            url: "download/report_flush.php",
            success: function(data){

            }
        }
    )
}
