<?php

namespace App\Imports;

use App\Localities;
use App\Municipalities;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithCustomCsvSettings};

class LocalidadesImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $clave = ltrim($row['c_mnpio'],0);
        $municipio = trim($row['d_mnpio']);

        $fk_municipio = Municipalities::where('clave',$clave)
            ->where('name','like','%'.$municipio.'%')
            ->where('fk_states',$row['c_estado'])
            ->first();
        return new Localities([
            'name' => $row['d_asenta'],
            'zip_code' => $row['d_codigo'],
            'tipo_asentamiento' => $row['d_tipo_asenta'],
            'city' => $row['d_ciudad'],
            'zona' => $row['d_zona'],
            'clave_ciudad' => $row[ 'c_cve_ciudad'],
            'fk_municipalities' => $fk_municipio['id']
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }
}
