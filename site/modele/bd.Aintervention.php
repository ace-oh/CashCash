<?php

class Intervention extends Model
{
    protected $fillable = ['date', 'agent', 'description'];

    public static function getInterventionsDateAgent($date, $agent)
    {
        return self::where('date', $date)->where('agent', $agent)->get();
    }
}

?>

