<?php

namespace Peak\Laravel\Eloquent\Model ;

trait Translater {

	use Property;

	/**
	 * 模型转化翻译的属性名
	 * */
	protected static $MODEL_TRANSLATE = 'translate';

	/**
	 * 检测model
	 * */
	private static function get_model_translate_property()
	{
		return property_exists(__CLASS__, self::$MODEL_TRANSLATE);
	}

	/**
	 * [level-3] 转化指定的Model属性
	 * 根据prop转化指定属性，prop=空，则转化翻译所有属性；$translate中未指定的属性将被忽略。
	 * @prop mixed string|array， string：需要被翻译的属性，分隔符为','
	 * @prf 转化属性名前缀，默认为'_'
	 * @ext 转化属性名后缀，默认为''
	 * @return 成功true；如果Model未指定translate属性名，则返回false。
	 * */
	public function tranlateProperty($prop=null, $prf='_', $ext=''):bool
	{
		if ( !self::get_model_translate_property()) return false;

		if ( $prop ) {
			$prop = is_array($prop) ? $prop : explode(',', $prop);
			$prop = array_intersect($prop, static::$$MODEL_TRANSLATE);
		} else {
			$prop = static::$$MODEL_TRANSLATE;
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