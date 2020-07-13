<?php
require_once('tcpdf_include.php');
$TEMP_LOCATION = $_SERVER['DOCUMENT_ROOT'] . "Creative_Aging/temp/";

$filename = $_REQUEST['filename'];
$entry_arr = $_REQUEST['entries'];
$attendance_arr = $_REQUEST['attendees'][0];

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Creative Aging Cincinnati - ' . date("D M d, Y"));
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, ('Creative Aging Cincinnati - ' . date("D M d, Y")), "", array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 9, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print
$report_total_attendance = '
        <table class="table table-custom">
            <tr class="table-head">
                <th class="table-col-r">Total Attendees</th>
                <th class="table-col-r">Total Children</th>
                <th class="table-col-r">Total Adults</th>
                <th class="table-col-r">Total Seniors</th>
            </tr>
            <tr class="table-alt-0 table-row">
                <th class="table-col-r">' .$attendance_arr["temp_total"]. '</th>
                <th class="table-col-r">' .$attendance_arr["total_children"]. '</th>
                <th class="table-col-r">' .$attendance_arr["total_adults"]. '</th>
                <th class="table-col-r">' .$attendance_arr["total_seniors"]. '</th>
            </tr>
        </table>
        <hr>
';
$report_entry_start = '
        <table style="border: 1px solid black">
            <tr class="table-head">
                <th class="table-col-r" style="border: 1px solid black">Program</th>
                <th class="table-col-r" style="border: 1px solid black">Topic</th>
                <th class="table-col-r" style="border: 1px solid black">Date</th>
                <th class="table-col-r" style="border: 1px solid black">Facility</th>
                <th class="table-col-r" style="border: 1px solid black">Total Attendees</th>
                <th class="table-col-r" style="border: 1px solid black">Children Attendees</th>
                <th class="table-col-r" style="border: 1px solid black">Adult Attendees</th>
                <th class="table-col-r" style="border: 1px solid black">Senior Attendees</th>
                <th class="table-col-r" style="border: 1px solid black">Funding Source</th>
            </tr>
';
$report_entry_body = '';
for($i = 0; $i < count($entry_arr); $i++){
    $entry_row = '';
    if($i % 2 == 0){
        $entry_row .= '<tr class="table-alt-0 table-row">';
    } else {
        $entry_row .= '<tr class="table-alt-1 table-row" style="background-color: #cdcdcd">';
    }
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' . $entry_arr[$i]["program_name"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["program_topic"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["date_start"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["facility_name"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["total_attendees"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["num_children"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["num_adults"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["num_seniors"] . '</th>';
    $entry_row .= '<th class="table-col-r" style="border: 1px solid black">' .$entry_arr[$i]["funding_name"] . '</th>';

    $entry_row .= '</tr>';

    $report_entry_body .= $entry_row;
}
$report_entry_end = '
        </table>
        <br>
';



$html = $report_entry_start . $report_entry_body . $report_entry_end . $report_total_attendance;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output($TEMP_LOCATION . $filename, 'F');
