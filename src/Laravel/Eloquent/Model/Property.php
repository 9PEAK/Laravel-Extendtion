<?php

namespace Peak\Laravel\Eloquent\Model;

/* Model 模块的底层函数
 *
 * */

trait Property {


	private static $config_file = 'model';



	/**
	 * 获取属性列表
	 * */
	public static function listProperty($key)
	{
		$key = [
			self::$config_file,
			static::class,
			$key,
		];
		return config(join('.', $key));
	}



	/**
	 * [level-2] 获取Model的属性参数
	 * @return $key model的属性名称 支持链式调用，分隔符为“.”
	 * @return
	 *
	 * */
	public function getProperty ($key, $val=null)
	{

		if ($key&&isset($val)) {
			return array_search($val, self::listProperty($key));
		}

		if ($key) {
			return self::listProperty($key.'.'.$this->$key);
		}

	}

}
