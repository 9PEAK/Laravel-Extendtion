<?php

namespace Peak\Laravel\Http\Middleware;

use Illuminate\Http\Request;
/**
 * 跨域中间件
 * */
class CrossHttp
{

	protected static $domain = [];

	public function handle (Request $req, \Closure $next)
	{
		$res = $next($req);

		// 获取当前域名
		$domain = $req->getHost();

		// 获取域名配置
		self::$domain = @self::$domain[$domain] ?: @self::$domain['*'];
		$domain = '*';
		// 设置Header
		if (self::$domain) {
			$res->header('Access-Control-Allow-Origin', $domain);
			foreach (self::$domain as $key=>$val) {
				$res->header('Access-Control-Allow-'.ucfirst($key), $val);
			}
		}

		return $res;
	}


	/**
	 * 设置域名
	 * @param $domain array 多维数组，域名url(不含http:///)作键名，值是拥有Header、Methods等键值对组成的数组；
	 * */
	static function init (array $domain=[])
	{
		self::$domain = $domain;
	}



}
