<?php
namespace Nrz\Base\Traits;
trait ApiResponse
{

    protected function successResponse($data, $code, $message = null)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = null, $code = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => ''
        ], $code);
    }

}
