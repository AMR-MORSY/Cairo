<?php

namespace App\Imports\Sites;

use App\Models\Sites\Site;
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
            "*.Site Code"=>["required","unique:sites,site_code","regex:/^([0-9a-zA-Z]{4,6}(up|UP))|([0-9a-zA-Z]{4,6}(ca|CA))|([0-9a-zA-Z]{4,6}(de|DE))$/"],
            "*.Site Name"=>["required", "regex:/^([0-9a-zA-Z_-]|\s){2,60}$/"],
            "*.RNC"=>["nullable", "regex:/^([0-9a-zA-Z_-]|\s){3,50}$/"],
            "*.BSC"=>["nullable", "regex:/^([0-9a-zA-Z_-]|\s){3,50}$/"],
            "*.office"=>["nullable","regex:/^[0-9a-zA-Z_-]{3,50}$/"],
            "*.type"=>["nullable","regex:/^Outdoor|Shelter|Micro$/"],
            "*.severity"=>["nullable","regex:/^Gold|Silver|Bronze$/"],
            "*.category"=>["nullable","regex:/^VIP|NDL|(VIP \+ NDL)|BSC|Normal$/"],
            "*.sharing"=>["nullable","regex:/^Yes|No$/"],
            "*.host"=>["nullable","regex:/^OG|VF|WE|ET$/"],
            "*.gest"=>["nullable","regex:/^OG|VF|WE|ET$/"],
            "*.2G"=>["nullable","regex:/^(100)|[1-9]\d?$/"],
            "*.3G"=>["nullable","regex:/^(100)|[1-9]\d?$/"],
            "*.4G"=>["nullable","regex:/^(100)|[1-9]\d?$/"],
            "*.oz"=>["nullable","regex:/^Cairo South|Cairo East|Cairo North|GZ$/"],
            "*.zone"=>["nullable","regex:/^(Cairo)$/"],
            
        ];
    }
    public function customValidationMessages()
{
    return [
        'type.regex' => 'The site type must be (Outdoor|Micro|Shelter)',
        'severity.regex' => 'The site severity must be (Gold|Selver|Bronze)',
        'category.regex' => 'The site category must be (VIP|VIP + NDL|NDL|Normal|BSC)',
        'sharing.regex' => 'The sharing status Either (Yes|No)',
        'gest.regex' => 'should be one of (OG|VF|WE|ET)',
        'host.regex' => 'should be one of (OG|VF|WE|ET)',
        "2G.regex"=>"Cells number from 1-100",
        "3G.regex"=>"Cells number from 1-100",
        "4G.regex"=>"Cells number from 1-100",
        "*oz.regex"=>"Operation Zone:(Cairo South|Cairo East|Cairo North|GZ)",
        "zone.regex"=>"Zone must be Cairo",

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

