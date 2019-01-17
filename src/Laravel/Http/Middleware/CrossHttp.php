<?php

namespace Peak\Laravel\Http\Middleware;

use Illuminate\Http\Request;
/**
 * 跨域中间件
 * */
class CrossHttp
{

	public function handle (Request $req, \Closure $next)
	{
		$res = $next($req);

		foreach (self::$config as $key=>$val) {
			$res->header('Access-Control-Allow-'.ucfirst($key), $val);
		}

		return $res;
	}

	/**
	 * 设置参数
	 * */

	protected static $config = [];

	static function config (array $config=[])
	{
		self::$config = $config;
	}


}
