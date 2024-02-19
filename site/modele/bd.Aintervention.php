<?php

include_once "chemin/vers/Model.php"; // Assurez-vous de fournir le bon chemin vers la classe Model

class Intervention extends Model
{
    protected $fillable = ['date', 'agent', 'description'];

    public static function getInterventionsDateAgent($date, $agent)
    {
        return self::where('date', $date)->where('agent', $agent)->get();
    }
}

?>


