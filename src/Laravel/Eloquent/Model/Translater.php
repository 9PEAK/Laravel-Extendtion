<?php

namespace Peak\Laravel\Eloquent\Model ;

trait Translater {

	/**
	 * 检测翻译属性是否已设置
	 * */
	private static function translation_defined():bool
	{
		return property_exists(static::class, 'translation');
	}


	private static function translation_format (&$dat)
	{
		if (count($dat)==count($dat, true)) {
			foreach ($dat as $k=>&$v) {
				$v = [
					'key' => $k,
					'val' => $v,
				];
			}
		} else {
			foreach ($dat as &$group) {
				self::{__FUNCTION__}($group);
			}
		}
	}


	/**
	 * 获取属性列表
	 * */
	public static function translationList ($key, $format=false)
	{
		if (!self::translation_defined()) return false;
		$key = $key ? @static::$translation[$key] : static::$translation;

		if ($format) {
			self::translation_format($key);
			$key = array_values($key);
		}

		return $key;
	}


	/**
	 * 翻译或反翻译属性
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
	 * 转化指定的或所有的Model属性
	 * 根据prop转化指定属性，prop is null，则转化翻译所有属性；$translate中未指定的属性将被忽略。
	 * @prop mixed string|array， string：需要被翻译的属性，分隔符为','
	 * @prf 转化属性名前缀，默认为'_'
	 * @ext 转化属性名后缀，默认为''
	 * @return 成功true；如果Model未指定translate属性名，则返回false。
	 * */
	public function translatePropertyList ($prop=null, $prf='_', $ext=''):bool
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