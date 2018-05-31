<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

	public $timestamps = false;

	//----------------------------------------------------------------	

	public static function get_setting($key) 
	{
		return Setting::where('key', $key)->first()->value;
	}

	//----------------------------------------------------------------	

}
