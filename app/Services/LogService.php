<?php
/**
 * Created by PhpStorm.
 * User: sanja
 * Date: 11/12/2018
 * Time: 9:51 PM
 */

namespace App\Services;


use App\Models\Log;
use App\Models\LogType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LogService
{
    public function log($message, $type = 'ACTIVITY'){
        if ($logType = LogType::whereName($type)->first()){
            $log = new Log;
            $log->users_id = Auth::user()->id;
            $log->message = $message;
            $log->timestamp = Carbon::now();
            $log->log_type_id = $logType->id;
            $log->save();
        }
    }
}