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
//		$res->header('Access-Control-Allow-Origin', 'http://crm.wechat.9peak.net');
		$res->header('Access-Control-Allow-Origin', '*');
		$res->header('Access-Control-Allow-Header', 'Origin, Content-Type, Cookie, Accept, multipart/form-data, application/json');
		$res->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
		$res->header('Access-Control-Allow-Credentials', 'false');
		return $res;
	}
}
