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



	/**
	 * 模型转化翻译的属性名
	 * */
	protected static $model_translation = 'translation';

	/**
	 * 检测model
	 * */
	private static function translation_defined():bool
	{
		return property_exists(__CLASS__, static::$model_translation);
	}

	/**
	 * [level-3] 转化指定的Model属性
	 * 根据prop转化指定属性，prop=空，则转化翻译所有属性；$translate中未指定的属性将被忽略。
	 * @prop mixed string|array， string：需要被翻译的属性，分隔符为','
	 * @prf 转化属性名前缀，默认为'_'
	 * @ext 转化属性名后缀，默认为''
	 * @return 成功true；如果Model未指定translate属性名，则返回false。
	 * */
	public function translateProperty($prop=null, $prf='_', $ext=''):bool
	{
		if ( !self::translation_defined()) return false;

		if ( $prop ) {
			$prop = is_array($prop) ? $prop : explode(',', $prop);
			$prop = array_intersect($prop, $this->{static::$model_translation});
		} else {
			$prop = $this->{static::$model_translation};
		}

		if ($prop) {
			foreach ( $prop as $k ) {
				if ( $k ) {
					$this->{$prf.$k.$ext} = $this->getProperty($k);
				}
			}
		}

		return true;

	}


}