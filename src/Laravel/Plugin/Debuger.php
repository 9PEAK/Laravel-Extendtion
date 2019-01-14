<?php

namespace Peak\Laravel\Plugin;
### 即将废弃
trait Debuger {

	private static $debug;

	public static function debug ($dat=null)
	{
		if ($dat) {
			self::$debug = $dat;
		} else {
			return self::$debug;
		}
	}

}
