const PROGRAM_NAME = 'program_name';
const PROGRAM_TOPIC = 'program_topic';
const DATE = 'date_start';
const FACILITY_NAME = 'facility_name';
const NUM_CHILDREN = 'num_children';
const NUM_ADULTS = 'num_adults';
const NUM_SENIORS = 'num_seniors';
const ENTRY_TOTAL_ATTENDEES = 'total_attendees';
const FUNDING_NAME = 'funding_name';

const REPORT_TOTAL_ATTENDEES = 'temp_total';
const REPORT_TOTAL_CHILDREN = 'total_children';
const REPORT_TOTAL_ADULTS = 'total_adults';
const REPORT_TOTAL_SENIORS = 'total_seniors';



function requestPDF(){
    console.log("<+|/ Request sent /|->");
    let request = new XMLHttpRequest();
    $.ajax({
        type: "POST",
        url: "download/report_download.php",
        data:{
            entries: reportEntries,
            attendees: reportAttendees
        },
        success: function(data){
            console.log("<-| Request processed |+>");
            console.log(data);
        }
    });

}
