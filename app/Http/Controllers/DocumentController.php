<?php


namespace App\Http\Controllers;

use App\Documents;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use palanik\lumen\Middleware\LumenCors;
use PDF;
use App\Util;

class DocumentController extends Controller
{
    public function insert(Request $request){
        $document = Documents::create($request->all());
        return response()->json($document,201);
    }

    public function getDocuments(){
        return response()->json(Documents::all());
    }

    public function getDocumentById($id){
        return response()->json(Documents::find($id));
    }

    public function updateById($id, Request $request){
        $document = Documents::findOrFail($id);
        $document->update($request->all());
        return response()->json($document,200);
    }

    public function deleteById($id){
        Documents::findOrFail($id)->delete();
        return response('Delete Successfully',200);
    }

    protected function getConfigArgs()
    {
        $opensslconf = file_get_contents(Util::AC_PATH.'openssl.cnf');
        return $configargs = array(
            "configargs" => $opensslconf,
            'private_key_bits'=> 4096,
            'x509_extensions' => 'v3_ca',
            'digest_alg' => "sha512",
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        );
    }
    protected function getConfigPrivateKey(){
        $config = array(
            'digest_alg' => 'sha512',
            'private_key_bits' => 4096,
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        );

        return $config;
    }

    protected function createNewPairKey($userpassword){

        $config = $this->getConfigPrivateKey();
        $new_resp = openssl_pkey_new($config);
        openssl_pkey_export($new_resp, $privateKey, $userpassword);
        $details=openssl_pkey_get_details($new_resp);
        $publicKey=$details['key'];
        return array('private_key' =>$privateKey,'public_key' => $publicKey);
    }

    protected function getCetificate( $csr){
        $passphrase = 'Admcs1234567a';
        //autoridad cerficadora
        $cacert = Storage::get('CA/certs/ca.cer');
        $privkey = array(Storage::get('CA/private/ca.key.pem'), $passphrase);
        $sscert =openssl_sign($csr,$cacert, $privkey,$this->getConfigArgs());
        openssl_x509_export($sscert, $final);
        return $final;
    }

    public function getDateMilitary(){
        date_default_timezone_set('America/Mexico_City');
        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $date = date("d-m-Y H:i:s",$date_array[1]);
//        return $date.":" . $date_array[0];
        return $date;
    }

    protected function getDN(){
        $dn = array(
            //"serialNumber" => env(),
            "owner" => env('RESPONSIBLE'),
            "2.5.4.45" => env('RFC'),
            "countryName" =>  env('COUNTRY_NAME'),
            "stateOrProvinceName"  => env('STATE_PROVINCE'),
            "localityName"  => env('LOCALITY'),
            "postalCode" => env('POSTAL_CODE'),
            "street" => env('STREET'),
            "organizationName" => env('ORGANIZATION'),
            "organizationalUnitName"  => env('ORGANIZATIONAL_UNIT_NAME'),
            "commonName" => env('NAME_CA'),
            "emailAddress" => env('EMAIL'),
        );
        return $dn;
    }

    //create AC
    public function createAC(){
        $pairKey= $this->createNewPairKey(env('AC_PASSWORD'));
        Storage::put('ca/private/ca.key.pem',$pairKey['private_key']);
        $csr = openssl_csr_new($this->getDN(), $pairKey['private_key'], $this->getConfigArgs());
        $sscert = openssl_csr_sign($csr, null, $pairKey['private_key'], 7300, $this->getConfigArgs());
        openssl_x509_export($sscert, $certout);
        Storage::disk('local')->put('ca/certs/ca.cer',$certout);
//        dd(shell_exec('openssl x509 -noout -text -in /var/www/html/eFirmas/storage/app/CA/certs/ca.cert.pem'));
        return $certout;
    }

    public function upload(Request $request){

        dd($this->getDateMilitary());

        $passphrase = 'Admcs1234567a';
        //autoridad cerficadora
        $cacert = Storage::get('CA/certs/ca.cer');
        $public=openssl_pkey_get_public($cacert);
        $privkey = array(Storage::get('CA/private/ca.key.pem'), $passphrase);
        $open=openssl_pkey_get_details($privkey);
        dd($open);

        $userpass = 'Admcs1234567';
        $opensslconf = $this->getConfig();
        $configargs = array(
            "config" => $opensslconf,
            'private_key_bits'=> 4096,
            'extension' => 'usr_cert',
            'default_md' => "sha512",
            'private_key_type' => OPENSSL_KEYTYPE_RSA
        );

        $out = null;
        $csrout =null;
        //configuración del certificado
        $dn = array(
            "countryName" => "MX",
            "stateOrProvinceName" => "Tabasco",
            "localityName" => "centla",
            "organizationName" => "Luis miguel",
            "organizationalUnitName" => "AAHL960929",
            "commonName" => "LUIS MIGUEL ALAMILLA HERNNADEZ",
            "emailAddress" => "susu@csdocs.com"
        );
        $privateKey = $this->createNewPairKey($request['password']);
        $privateKey =  array($privateKey['private_key'], $request['password']);

         $csr = openssl_csr_new($dn,$privateKey, $this->getConfigArgs());

        $certificateGenerated = $this->getCetificate($csr);

        dd(Storage::disk('local')->put('CA/newUserCerts/final8.cer', $certificateGenerated));

        Storage::disk('local')->put('firmas/publicKey', $pubKey);
        dd(Storage::disk('local')->put('firmas/privateKey', $out));

        $cacert = Storage::get('firmas/certificado.pem');
        $cert = openssl_csr_new($dn, $respuesta);
        $key = Storage::get('firmas/private.key');

        $sscert = openssl_csr_sign($cert, $cacert, $key, 865);

        openssl_x509_export($sscert, $certout);

        dd($path = Storage::disk('local')->put('firmas/certificado.cer',$certout));

        $pubKey = openssl_pkey_get_details($respuesta);
        dd($pubKey = $pubKey['key']);

        $privateKey = '';
        //openssl_pkey_export_to_file($respuesta, 'private.key');
        openssl_pkey_export($respuesta,$privateKey, $passphrase);
        $path = Storage::disk('local')->put('firmas/private.key',$privateKey);

        dd($path);
        dd();

        $data = $request->allFiles();
        $headers = $request->header('api-token');
        $fk_users = User::where('api_token',$headers)->value('id');
        foreach ($data as $key => $valor){
            $fk_documents_type =  DB::table('documents_type')
                ->where('name', 'LIKE' ,'%'.Str::upper($key).'%')
                ->value('id');
            $path = Storage::put('/'.Str::upper($key), $data[$key]);
            $document = Documents::create([
                'name' => basename($path),
                'src_document'=>  Storage::disk('local')->path($path),
                'status_document' => 'Validado',
                'validity' => '1',
                'fk_users' => $fk_users,
                'fk_documents_type' => $fk_documents_type
            ]);
        }

        return response()->json(['status' => 'Successfully'], 200);
    }

    public function getContancia(Request $request){
        PDF::SetTitle('CONSTANCIA');
        PDF::SetSubject('CONSTANCIA');
        // set custom header data
        PDF::setHeaderCallback(function ($pdf){
            $imgHeader = file_get_contents(Util::IMG_PATH.'logo.png');
            $pdf->Image('@'.$imgHeader, 30, 10, 160, '', 'png', '', 'T', false, 300, '', false, false, 0, false, false, false);
        });
       //set Custom Footer data
        PDF::setFooterCallback(function($pdf) {
            // Position at 5 mm from bottom
            $pdf->SetY(-7);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
                        // Page number
            $pdf->Cell(0, 0, ' Av. Paseo de la Sierra 435, Reforma, 86080, Villahermosa, Tabasco', 0, false, 'C', 0, '', 0, false, 'T', 'M');

        });
        // set margins
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT, 0);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);
        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        // ---------------------------------------------------------
        // set default font subsetting mode
        PDF::setFontSubsetting(true);

       // PDF::SetFont('dejavusans', '', 10, '', true);

        PDF::AddPage();
        // Set some content to print
        $html= Util::HTML.Util::HEAD.Util::STYLE.'
<body>
    <p class="font-17 bold align-center">SERVICIO DE ADMINISTRACIÓN DE FIRMA ELECTRÓNICA</p>
    <p class="font-13 align-right bold">Comprobante de Generación del Certificado Digital de Firma Electrónica</p>

    <p class="align-right bold font-13">Fecha y Hora de Generación:'. $this->getDateMilitary().' horas</p>
    <p class="align-right bold font-13">Número de Operación:'.date('ym') .'</p>
    <span>
        <p class="align-justify font-13">El Servicio de Administración Tributaria certifica que:  con RFC: , en representación del contribuyente:  con RFC: , entregó un archivo de requerimiento que contiene la solicitud para la generación del certificado de Firma Electrónica de su representado. </p>
        <p class="align-justify font-13">Que llevó a cabo la acreditación de identidad de conformidad con lo establecido en los párrafos 6 y 7 del artículo 17-D del Código Fiscal
                                            de la Federación vigente.
        </p>
        <p class="align-justify font-13">Asimismo, que como resultado del proceso se le hace entrega de un archivo que contiene el Certificado Digital de su representado, con número de serie: , que de conformidad con el penúltimo párrafo del artículo 17-D del Código Fiscal de la Federación vigente, tiene una vigencia de 6 meses, contados a partir del:  horas.. hasta el horas., y con clave pública:</p>
    </span>

    <p class="align-justify font-13"> clave pública</p>
    <p class="align-center">_______________________________________________</p>
    <p class="align-center font-8">Firma de conformidad</p>
    <p class="align-center font-10">Nombre: </p>
    <p class="align-center font-10">RFC: </p>
    <p class="align-center font-8">En representación de:</p>
    <p class="align-center font-10">Nombre: </p>
    <p class="align-center font-10">RFC: </p>
    <p class="align-justify font-10">Para descargar posteriormente su Certificado Digital, si así lo requiere, deberá acceder a la página de internet del (www.).</p>
    <p class="align-justify font-10">El resguardo del archivo de la Clave Privada y del Certificado Digital generada, así como la selección del medio de almacenamiento de los mismos, es responsabilidad de la persona titular de la Firma Electrónica.</p>
    <p class="align-justify font-10">A través del correo electrónico manifestado para el trámite de N Firma Electrónica, podrá recibir notificaciones por parte del Servicio de Administración Tributaria.</p>



</body>
'. Util::HTMLCLOSE;

        // Print text using writeHTMLCell()
        PDF::writeHTML($html, true, false, true, false, '');
        // ---------------------------------------------------------
        // Close and output PDF document
        $style = array(
            'border' => true,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        PDF::write2DBarcode('RF: / Vigencia/ Vigencia/ Firma Electrónica Avanzada/ No. Serie/ No. Operación', 'QRCODE,L', 10,256, 20, 20, $style, 'N');

        // This method has several options, check the source code documentation for more information.
        PDF::Output('Constancia.pdf', 'I');
    }
}
