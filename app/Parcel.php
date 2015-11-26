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
        $parcel = Auth::user()->parcels()->findOrFail($id);
        $parcel_unpacked = $parcel->select
            (
                DB::raw
                    (
                        'ST_X(startpoint) AS start_x,
                        ST_Y(startpoint) AS start_y,
                        ST_X(endpoint) AS end_x,
                        ST_Y(endpoint) AS end_y'
                    )
            )->first();

        return $parcel_unpacked;

    }


}

