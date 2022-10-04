<?php

namespace App\Imports;

use App\Models\Site;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;


HeadingRowFormatter::default('none');


class SitesImport implements ToModel, WithHeadingRow, WithValidation ,WithBatchInserts ,WithChunkReading
{
    use Importable ;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function rules(): array
    {
        return[
            "*.Site Code"=>["required","unique:sites,site_code","regex:/^([0-9a-zA-Z_]{4,6}(up|UP))|([0-9a-zA-Z]{4,6}(ca|CA))$/"],
        ];
    }
    public function model(array $row)
    {
        return new Site([
            "site_code"=>$row['Site Code'],
            "site_name"=>$row['Site Name'],
            "BSC"=>$row['BSC'],
            "RNC"=>$row['RNC'],
            'office'=>$row['office'],
            'type'=>$row['type'],
            'category'=>$row['category'],
            'severity'=>$row["severity"],
            'sharing'=>$row['sharing'],
            'host'=>$row['host'],
            'gest'=>$row["gest"],
            'oz'=>$row['oz'],
            'zone'=>$row['zone'],
            "2G_cells"=>$row["2G"],
            "3G_cells"=>$row["3G"],
            "4G_cells"=>$row["4G"]
        ]);
    }
    public function batchSize(): int
    {
        return 100;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}

