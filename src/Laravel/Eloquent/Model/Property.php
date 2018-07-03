<?php

namespace Peak\Laravel\Eloquent\Model;

/* Model 模块的底层函数
 *
 * */

trait Property {


	private static $config_file = 'model';



	/**
	 * 获取Model的class名称
	 * */
	private static function model_class_name ()
	{
		$arr = explode('\\', __CLASS__);
		return $arr[count($arr)-1];
	}




	/**
	 * 获取属性列表
	 * */
	public static function listProperty($key)
	{
		$key = [
			self::$config_file,
			self::model_class_name(),
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
			return array_search(config(join('.', self::listProperty($key))), $val);
		}

		if ($key) {
			return config(join('.', self::listProperty($key.'.'.$this->$$key)) );
		}

	}

}
