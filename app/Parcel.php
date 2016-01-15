<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Parcel extends Model
{
    protected $fillable =
        [
            'width',
            'height',
            'depth',
            'weight',
            'startaddress',
            'endaddress',
            'startpoint',
            'endpoint',
            'contents'
        ];



    //Find owner of Parcel
    public function owner()
    {
        return $this->belongsTo('App\User');
    }




    //Take binary object points from database and convert into accessible form
    public function unpackPoints($id)
    {
        //TODO CHECK IF WE NEED TO STORE THE POINTS AS GEOMETRY - COULD JUST STORE AS POINTS
        $parcel = Auth::user()->parcels()->findOrFail($id);
        $parcel_unpacked = $parcel->select
            (
                DB::raw
                    (
                        'id,
                        user_id,
                        startaddress,
                        endaddress,
                        ST_X(startpoint) AS start_lat,
                        ST_Y(startpoint) AS start_lng,
                        ST_X(endpoint) AS end_lat,
                        ST_Y(endpoint) AS end_lng'
                    )
            )->first();


        return $parcel_unpacked;

    }


    public function createSpatialGeometry($point)
    {
        $geom = DB::raw("GeomFromText('POINT($point)')");

        return $geom;
    }




}

