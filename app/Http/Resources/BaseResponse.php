<?php
/**
 * Created by PhpStorm.
 * User: Alif Jafar
 * Date: 9/21/2019
 * Time: 9:37 PM
 */

namespace App\Http\Resources;


use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class BaseResponse
{
    private $data = [];
    private $code;
    private $status = Response::HTTP_OK;

    public static function instance()
    {
        return new BaseResponse();
    }

    public function __construct()
    {
        $this->code = $this->status;
        return $this;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function build()
    {
        return response()->json([
            'statusCode' => $this->status,
            'success' => true,
            'data' => $this->data,
        ], $this->status);
    }

}
