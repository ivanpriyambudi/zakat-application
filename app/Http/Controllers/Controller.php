<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $limit = 20;

    public $page = 1;

    function getLimit(): int
    {
        return is_numeric(request()->query('limit')) ? request()->query('limit') : $this->limit;
    }

    function getPage(): int
    {
        return is_numeric(request()->query('page')) ? request()->query('page') : $this->page;
    }

    public function successResponse($data = '', $message = '', $code = 200)
    {
        return [
            'statusCode' => $code,
            'succcess' => true,
            'message' => $message,
            'data' => $data
        ];
    }

    public function errorResponse($message = '', $code = 400)
    {
        return [
            'statusCode' => $code,
            'succcess' => false,
            'message' => $message,
        ];
    }

    public function successMessage($data = '', $context = '', $modul = '')
    {
        $msg = '';
        if ($context === 'store') {
            $msg = 'Berhasil membuat';
        } else if ($context === 'update') {
            $msg = 'Berhasil mengubah';
        } else if ($context === 'destroy') {
            $msg = 'Berhasil menghapus';
        } else {
            $msg = 'Berhasil';
        }
        $msg = $msg . ' ' . $modul;
        return $this->successResponse($data, $msg);
    }
}
