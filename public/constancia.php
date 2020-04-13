<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+



// Include the main TCPDF library (search for installation path).
require_once('eFirmas/vendor/tcpdf/tcpdf.php');
require_once('eFirmas/vendor/tcpdf/examples/tcpdf_include.php');
require_once('eFirmas/.env');
class MYPDF extends TCPDF {

    // Page footer


    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }


}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CSDOCS');
$pdf->SetTitle('CONSTANCIA');
$pdf->SetSubject('CONSTANCIA');
$pdf->SetKeywords('EFIRMA, PDF, CONSTANCIA, CSDOCS');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.'', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
	require_once(dirname(__FILE__) . '/lang/spa.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.


// Add a page
// This method has several options, check the source code documentation for more information.

$pdf->SetFont('dejavusans', '', 10, '', true);

$pdf->AddPage();



// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
</head>

<body>
        <p style="text-align: right;">Villahermosa, Tabasco a</p>
        <input type="datetime" name="fecha"  value="<?php echo date("Y-m-d\TH-i");?>">
        <p style="text-align: right;">Oficio: SF/UTIC/XXX/2020.</p>
        <p style="text-align: right;">Asunto: XXXXXXXXX</p>
        <br>
        <br>
        <br>
        <p style="text-align: justify;">Ing. Guillermo Castro García</p>
        <p style="text-align: justify;">Coordinador de Modernización Administrativa</p>
        <p style="text-align: justify;">Secretaría de Administración e Innovación Gubernamental</p>
        <p style="text-align: justify;"><strong>Presente</strong></p>

        <br>
        <br>
        <br>
        <br>
        <br>
        <p>A través de la presente le solicito...</p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="text-align: justify;">Agradeciendo su atención al presente, me despido enviándole un cordial saludo.</p>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="text-align: center;"><strong>Atentamente</strong></p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="text-align: justify;">Marco Antonio Carpio</p>
        <p style="text-align: justify;">Sgvbjkduiwehdkdsajiod</p>
        <br>
        <br>
        <p style="text-align: justify;">Oculto en el certificado</p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="text-align: justify;"><strong>C.c.p</strong></p>
        <p style="text-align: justify;"><strong>ING’ERV/</strong></p>

<tr style="height: 14.65pt;">
<td style="width: 170.65pt; border: solid windowtext 1.0pt; border-top: none; padding: 0cm 5.4pt 0cm 5.4pt; height: 14.65pt;" width="228"> $users[$user_name]</td>
<td style="width: 141.05pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 14.65pt;" colspan="2" width="188">$users[$user_name] </td>
<td style="width: 191.55pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; padding: 0cm 5.4pt 0cm 5.4pt; height: 14.65pt;" colspan="2" width="255"> $users[$user_name]</td>
</tr>
<tr style="height: 14.65pt;">
<td style="width: 170.65pt; border: solid windowtext 1.0pt; border-top: none; padding: 0cm 5.4pt 0cm 5.4pt; height: 14.65pt;" width="228">


</body>

</html>
EOD;


$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$pdf->SetAlpha(0.2);
$pdf->Image('images/fondo.png', 0, 95, 150, 202, '', 'http://www.tcpdf.org', '', true, 100);
// restore auto-page-break status
$pdf->SetAlpha(1);
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);




// data loading
//$data = $pdf->LoadData('data/table_data_demo.txt');
$db = Connection("csdocs-efirmas");
$db->fetchObject();
$data = array();
$rs = $db->recordSet ("SELECT * FROM users");
while ($users = $db ->next ($rs))
{
    $data[] = array ($users->user_name,$users->last_name,$users->second_last_name,$users->rfc,$users->curp,$users->password,$users->user_type,$users->genders,$users->telephone,$users->fk_localities,$users->address,$users->fk_user_status);
}


// reset pointer to the last page
$pdf->lastPage();




// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Constancia.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
