<?php

namespace App\Contracts\Eloquent\Model;

/**
 * 根据Model的$fillable
 *
 * @notice: 必须在Model内部引用
 */
trait Attribute {

	public static function fillableFromArrayList (array &$arr)
	{
		$cls = self::class ;
		$obj = new $cls ;
		foreach ( $arr as &$v ) {
			$v = $obj->fillableFromArray($v);
		}
		return $arr;
	}

}
