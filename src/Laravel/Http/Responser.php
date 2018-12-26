<?php

namespace Peak\Laravel\Http;

/**
 * Provide response generating functions
 * typically used in various situtaions
 */
trait Responser {

	/**
     * Render a HTML response
     * @param  String $view View path
     * @param  Array $data Data to be passsed to view
     * @return HTTPResponse
     */

    protected function resView($tpl, $dat)
    {
        return view($tpl)->with($dat);
    }


    protected function resView404 ()
    {

    }


    /**
     * Send a file download response
     * @param  String  $path          File path
     * @param  boolean $forceDownload Force browser to initiate a download
     * @param  boolean $deleteFile    Whether the file should be deleted after download
     * @return HTTPResponse
     */
    protected function resFile($path, $forceDownload = true, $deleteFile = false)
    {
    	if ($forceDownload) {
    		return response()->download($path)->deleteFileAfterSend($deleteFile);
    	}

    	return response()->file($path);
    }




	/**
	 * JSON
	 * */

	protected static function res_json ($res, $msg='', $dat=null)
    {
	    return response()->json([
		    'res' => $res,
		    'msg' => $msg,
		    'dat' => $dat
	    ], 200);
    }


    // 成功
    protected function resJsonSuccess($msg='', $dat=null)
    {
        return self::res_json(1, $msg, $dat);
    }

	// 失败
	protected function resJsonFail($msg='', $dat=null)
	{
		return self::res_json(0, $msg, $dat);
	}


	// 未登录
	protected function resJsonUnlogin ($msg='', $dat=null)
	{
		return self::res_json(-1, $msg, $dat);
	}

	// 未授权
	protected function resJsonOAuth($msg='', $dat=null)
	{
		return self::res_json(-1.1, $msg, $dat);
	}

	// 无权限
	protected function resJsonNoPermission($msg='', $dat=null)
	{
		return self::res_json(-1.2, $msg, $dat);
	}


}