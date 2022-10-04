<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PowerAlarm extends Model
{
    use HasFactory;
    protected $table = "power_alarms";
    protected $guarded = [];

    // public function setStartDateAttribute($value)
    // {
    //     $start_date_str = "$value[0] $value[1]"; ////concatenate start date and time
    //     // $start_date = strtotime($start_date_str);
    //     $start_date_str= Date::excelToTimestamp($start_date_str);
    //     // $start_date=date('Y-m-d H:i:s',$start_date);
    //     // $this->attributes['start_date'] = $start_date;
    //     $this->attributes['start_date'] = $start_date_str;
    // }
    // public function setEndDateAttribute($value)
    // {
    //     $end_date_str = "$value[0] $value[1]"; ////concatenate start date and time
    //     $end_date_str= Date::excelToTimestamp($end_date_str);
    //     // $end_date = strtotime($end_date_str); ///chabging string to time
    //     // $end_date=date('Y-m-d h:i:s',$end_date);  /////formting the time to be inserted into timestamp column
    //     // $this->attributes['end_date'] = $end_date;
    //     $this->attributes['end_date'] = $end_date_str;
    // }

    // public function setDurationAttribute($value)
    // {
       

    //     $start_date = $value[0];
    //     $start_time = $value[1];
    //     $end_date = $value[2];
    //     $end_time = $value[3];
    //     $start_date_time = "$start_date $start_time";
    //     $end_date_time = "$end_date $end_time";
    //     $start_date_time_object = date_create($start_date_time);
    //     $end_date_time_object = date_create($end_date_time);
    //     $interval = date_diff($start_date_time_object, $end_date_time_object);
    //     $min = $interval->days * 24 * 60;
    //     $min += $interval->h * 60;
    //     $min += $interval->i;


    //     $this->attributes['duration'] = $min;

    // }
}
