<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use function Complex\ln;

class  Util {
    //Ruta imagenes
    const IMG_PATH = '/var/www/html/eFirmas/storage/app/img/';

    //ruta para openssl
    const CA_PATH = '/var/www/html/eFirmas/storage/app/CA/';

    const AC_PATH = '/var/www/html/eFirmas/storage/app/CA/certs/';

    const HEAD = '
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    </head>
                    ';
    const HTML = '<html>';
    const HTMLCLOSE = '</html>';
    const STYLE = '
                    <style>
                        .font-13{
                            font-size: 13px;
                        }
                        .font-10{
                            font-size: 10px;
                        }
                        .font-8{
                            font-size: 8px;
                        }
                        .font-family{
                         font-family: arial, helvetica, sans-serif;
                        }
                        .font-17{
                            font-size: 17px;
                        }
                        .bold{
                            font-weight: bold;
                        }
                        .align-center{
                            text-align: center;
                        }
                        .align-right{
                            text-align: right;
                        }
                        .align-left{
                            text-align: left;
                        }
                        .align-justify{
                            text-align: justify;
                        }
                    </style>
        ';
    public function validarCURP( $curp){
        if($this->curpValid(strtoupper($curp))){
            return true;
        }
        else {
            return false;
        }
    }

    protected function curpValid( $curp){
        $regex = '/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0\d|1[0-2])(?:[0-2]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/';
        $valid = preg_match($regex,$curp);
        if (!$valid)
            return false;
        function digitVerif($curp17){
            $dictionary='0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ';
            $lngSum = 0;
            $lngDigit= 0.0;
            $array ="";
            for ($i=1; $i<strlen($dictionary); $i++) {
                $lngSum = $lngSum + strrpos($dictionary, substr($dictionary, $i, 1)) * (18 - $i);
                $array = $array. " ".strrpos($dictionary, substr($dictionary, $i, 1));

            }
            dd($array);
            $lngDigit = 10 - $lngSum % 10;
            if($lngDigit == 10)
                return 0;
        }
        dd(digitVerif(substr($curp, 0, -1)));
        if (substr($curp, -1) )
            return false;
        return true;
    }


    //        $bMargin = PDF::getBreakMargin();
//        // get current auto-page-break mode
//        $auto_page_break = PDF::getAutoPageBreak();
//        // disable auto-page-break
//        PDF::SetAutoPageBreak(false, 0);
//        // set bacground image
//        PDF::SetAlpha(0.2);
//        $img = file_get_contents(Util::IMG_PATH.'fondo.png');
//        PDF::Image('@'.$img, 0, 95, 150, 202, '', '', '', true, 100);
//        // restore auto-page-break status
//        PDF::SetAlpha(1);
//        PDF::SetAutoPageBreak($auto_page_break, $bMargin);
//        // set the starting point for the page content
//        PDF::setPageMark();
}
