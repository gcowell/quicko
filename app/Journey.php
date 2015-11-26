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
        $parcel_unpacked = $parcel->unpackPoints($parcel->id);

        $start_lat = $parcel_unpacked->start_x;
        $start_lng = $parcel_unpacked->start_y;

        $end_lat = $parcel_unpacked->end_x;
        $end_lng = $parcel_unpacked->end_y;

        $user_id = Auth::id();

        $query_string = "*,ST_X(startpoint) AS start_x, ST_Y(startpoint) AS start_y ,ST_X(endpoint) AS end_x, ST_Y(endpoint) AS end_y,(3959*acos(cos(radians(?))*cos(radians(ST_X(startpoint)))*cos(radians(ST_Y(startpoint))-radians(?))+sin(radians(?))*sin(radians(ST_X(startpoint))))) AS startdistance, (3959*acos(cos(radians(?))*cos(radians(ST_X(endpoint)))*cos(radians(ST_Y(endpoint))-radians(?))+sin(radians(?))*sin(radians(ST_X(endpoint))))) AS enddistance";


          $journeys = $this->selectRaw($query_string, array($start_lat, $start_lng, $start_lat, $end_lat, $end_lng, $end_lat,))
            ->where('user_id', '!=', $user_id)
            ->having("startdistance", "<", $range)
            ->having("enddistance", "<", $range)
            ->orderBy("startdistance")
            ->get();

        return($journeys);

    }
}


