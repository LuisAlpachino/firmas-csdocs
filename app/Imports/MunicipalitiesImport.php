<?php

namespace App\Imports;

use App\Municipalities;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithCustomCsvSettings};

class MunicipalitiesImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Municipalities([
            'fk_states' => $row['fk_state'],
            'clave' => $row['clave'],
            'name' => $row['name'],
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }
}
