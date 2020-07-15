<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;


class Message extends Model
{
    public $fillable= [
        'user_id','message'
    ];
    //
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function formatTimeForHuman(){
        return Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans();
    }
}
