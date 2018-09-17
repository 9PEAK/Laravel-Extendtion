<?php

namespace Peak\Laravel\Eloquent\Model;

# json字段格式化
trait Formater {


	/**
	 * 模型格式化的属性名
	 * */
	private static $model_formation = 'formation';

	/**
	 * 检测model
	 * */
	private static function formation_defined():bool
	{
		return property_exists(__CLASS__, static::$model_formation);
	}


	/**
	 * 基于模板格式化数据
	 * */
	private static function format_as_tpl ($tpl, array $val)
	{
		return $tpl ? \Peak\Tool\Arr::intersectKey($tpl, $val, true) : false;
	}


	/**
	 * 获取基础模板格式
	 * */
	public static function getFormation ($key)
	{
		$tpl = static::$model_formation;
		return @self::$$tpl[$key];
	}


/*
	public function formatToJson ($key, array $val)
	{
		if (!self::formation_defined()) return false;

		$val = self::format_as_tpl(
			self::getFormation($key),
			$val
		);

		return $val===false ? false : json_encode($val);
	}
*/


	public function formatArray ($key, array $val)
	{
		if (!self::formation_defined()) return false;
//		if (is_array($val)) return false;

		return self::format_as_tpl(
			self::getFormation($key),
			json_decode($val, 1)
		);

	}




}