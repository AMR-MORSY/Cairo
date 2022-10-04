<?php

namespace App\Imports;

use App\Models\HighTempAlarm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Events\AfterImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

HeadingRowFormatter::default('none');

class HightempAlarmsImport implements ToModel ,WithHeadingRow ,WithBatchInserts ,WithChunkReading
{
  
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public $week, $year;

    

    public function __construct($week, $year)
    {
        $this->week = $week;
        $this->year = $year;
    }
  
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
    public function calculate_duration($value)
    {
        if (intval($value) > 0) {
            $inval_min = intval($value) * 24 * 60;
            $decimal_min = $value - intval($value);
            $decimal_min = Date::excelToTimestamp($decimal_min);
            $decimal_min = intval($decimal_min / 60);
            $total_min = $decimal_min + $inval_min;
            $min = $total_min;
        } else {
            $decimal_min = Date::excelToTimestamp($value);
            $decimal_min = intval($decimal_min / 60);
            $min = $decimal_min;
        }
        return $min;
    }
    public function transformTime($value)
    {
        $time = Date::excelToTimestamp($value);
        return $time = date("H:i:s", $time);
      
    }

    public function model(array $row)
    {
        return new HightempAlarm([

            "zone" => $row['Zone'],
            'operational_zone' => $row['OZ'],
            "area" => $row['Area'],
            'bsc' => $row['BSC Name'],
            'site_name' => $row['Site Name'],
            'site_code' => $row['Site Code'],
            'alarm_name' => $row['Alarm Name'],
         
            "duration" =>$this->calculate_duration($row["Duration"]) ,
         
            'start_date' => $this->transformDate($row['Occurred On(Date)']),
            "start_time" => $this->transformTime($row['Occurred On(Time)']),
        
            'end_date' => $this->transformDate($row['Cleared On(Date)']),
            "end_time" => $this->transformTime($row['Cleared On(Time)']),

            "week" => $this->week,
            'year' => $this->year

        ]);
    }
    public function batchSize(): int
    {
        return 100;
    }
    public function chunkSize(): int
    {
        return 100;
    }
}
