<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Journey extends Model
{
    protected $fillable =
        [
            'startpoint',
            'endpoint',
            'traveldate',
            'endaddress',
            'startaddress',
        ];




    public function owner()
    {
        return $this->belongsTo('App\User');
    }







    public function findMatchingJourneys (Parcel $parcel, $range)
    {

        if($range == 'default')
        {
            $range = 10;
        }

        $start_lat = $parcel->start_lat;
        $start_lng = $parcel->start_lng;
        $end_lat = $parcel->end_lat;
        $end_lng = $parcel->end_lng;

        $user_id = Auth::id();

        $query_string = "id, user_id, startaddress, endaddress, ST_X(startpoint) AS start_lat, ST_Y(startpoint) AS start_lng ,ST_X(endpoint) AS end_lat, ST_Y(endpoint) AS end_lng,(3959*acos(cos(radians(?))*cos(radians(ST_X(startpoint)))*cos(radians(ST_Y(startpoint))-radians(?))+sin(radians(?))*sin(radians(ST_X(startpoint))))) AS startdistance, (3959*acos(cos(radians(?))*cos(radians(ST_X(endpoint)))*cos(radians(ST_Y(endpoint))-radians(?))+sin(radians(?))*sin(radians(ST_X(endpoint))))) AS enddistance";
        //TODO factor out miles

          $journeys = $this->selectRaw($query_string, array($start_lat, $start_lng, $start_lat, $end_lat, $end_lng, $end_lat,))
            ->where('user_id', '!=', $user_id)
            ->having("startdistance", "<", $range)
            ->having("enddistance", "<", $range)
            ->orderBy("startdistance")
            ->get();

        return($journeys);

    }
}


