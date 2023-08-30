<?php

namespace App\Traits;

trait ApiResponser{

    protected function successResponse($data = null, $message = null, $code = 200)
	{
		return response()->json([
			'success'=> true, 
			'message' => $message, 
			'data' => $data,
			'error' => null
		], $code);
	}

	protected function errorResponse($error = null, $message = null, $code = 401)
	{
		return response()->json([
			'success'=> false,
			'message' => $message,
			'data' => null,
			'error' => $error
		], $code);
	}

}