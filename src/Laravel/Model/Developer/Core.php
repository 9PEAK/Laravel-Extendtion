<?php

namespace Peak\Laravel\Model\Developer;

class Core extends \Illuminate\Database\Eloquent\Model
{
	protected $table = '9peak_developer_user';
	public $timestamps = false;
	public $incrementing = false;

	protected $fillable = [
		'id' => 'id',
		'type' => 'type',
		'token' => 'token',
	];


	protected function hasUser ($cls, $key='id')
	{
		return $this->hasOne($cls, 'id', $key);
	}


	static function get ($token, $type=null)
	{
		$query = static::where('token', $token);
		isset($type) ? $query->where('type', $type) : $query->whereNull('type');
		return $query->first();
	}


}
