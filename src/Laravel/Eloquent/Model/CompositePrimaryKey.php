<?php

namespace App\Contracts\Eloquent;

trait CompositePrimaryKey
{

	public function saveByPrimaryKey(array $options =[])
	{
		# 单主键
		if ( !is_array($this->primaryKey) ) {
			return $this->save($options);
		}

		# 初始化数据
		$this->fill($options ?: $this->attributesToArray());
		$options = $this->attributesToArray();

		$qry = self::query();
		foreach ($this->primaryKey as $key ) {
			# 联合主键
			if ( array_key_exists($key, $options)) {
				$qry->where($key, $this->$key);
			} else {
				throw new \Exception('One part of unique keies (\''.$key.'\') is missing.');
			}
		}
		return $qry->update($options);

	}

}