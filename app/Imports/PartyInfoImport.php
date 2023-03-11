<?php

namespace App\Imports;

use App\PartyInfo;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PartyInfoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PartyInfo([
            'pi_code' => $row[0],
            'pi_name' => $row[1],
            'pi_type' => $row[2],
            'trn_no' => $row[3],
            'address' => $row[4],
            'con_person' => $row[5],
            'con_no' => $row[6],
            'phone_no' => $row[7],
            'email' => $row[8],
            'deleted_at' => $row[8],
        ]);
    }
}
