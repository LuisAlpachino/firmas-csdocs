<?php

namespace App\Imports;

use App\States;
use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithCustomCsvSettings};

class StatesImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new States([
            'name' => $row['estado'],
        ]);


    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1'
        ];
    }
}
