<?php

namespace Peak\Laravel\Eloquent\Model ;

trait Translater {

	/**
	 * 模型翻译的属性名
	 * */
	protected static $translation_key = 'translation';

	/**
	 * 检测翻译属性是否已设置
	 * */
	private static function translation_defined():bool
	{
		return property_exists(static::class, static::$translation_key);
	}

	/**
	 * 获取属性列表
	 * */
	public static function translationList ($key)
	{
		if (!self::translation_defined()) return false;
		$translation = static::$translation_key;
		return $key ? @static::$$translation[$key] : static::$$translation;
	}


	/**
	 * 翻译或者编码属性
	 * */
	public function translateProperty ($key, $val=null)
	{
		if (!$key) {
			return false;
		}

		if (isset($val)) {
			return array_search($val, self::translationList($key) ?: []);
		}

		return @self::translationList($key)[$this->$key];

	}



	/**
	 * [level-3] 转化指定的Model属性
	 * 根据prop转化指定属性，prop=空，则转化翻译所有属性；$translate中未指定的属性将被忽略。
	 * @prop mixed string|array， string：需要被翻译的属性，分隔符为','
	 * @prf 转化属性名前缀，默认为'_'
	 * @ext 转化属性名后缀，默认为''
	 * @return 成功true；如果Model未指定translate属性名，则返回false。
	 * */
	public function translateToNewProperty($prop=null, $prf='_', $ext=''):bool
	{

		if ( !self::translation_defined()) return false;

		if ( $prop ) {
			$prop = is_array($prop) ? $prop : explode(',', $prop);
			$prop = array_intersect_assoc(array_flip($prop), static::translationList(null));
		} else {
			$prop = array_keys(static::translationList(null));
		}

		foreach ( $prop as $k ) {
			$this->{$prf.$k.$ext} = $this->translateProperty($k);
		}

		return true;

	}


}