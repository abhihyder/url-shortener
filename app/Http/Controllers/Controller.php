<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public $status_code = HttpResponse::HTTP_OK;


    public function getStatusCode()
    {
        return $this->status_code;
    }


    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }


    public function respond($data, $header = [])
    {
        return response()->json($data, $this->getStatusCode(), $header);
    }

    public function respondWithData($data, $message = null)
    {
        return $this->respond([
            'success' => [
                'data' => $data,
                'message' => $message,
            ]
        ]);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    public function respondBadRequest($message)
    {
        return $this->setStatusCode(HttpResponse::HTTP_BAD_REQUEST)->respond([
            'error' => [
                'message' => $message,
            ]
        ]);
    }

    public function respondNotFound($message = 'Not found!')
    {
        return $this->setStatusCode(HttpResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }


    public function respondInternalError($message = 'Internal server error!')
    {
        return $this->setStatusCode(HttpResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }


    public function respondCreated($message, $data = null)
    {
        return $this->setStatusCode(HttpResponse::HTTP_CREATED)->respond([

            'success' => [
                'message' => $message,
                'data' => $data,
            ]
        ]);
    }

    public function respondSuccess($message)
    {
        return $this->respond([

            'success' => [
                'message' => $message,
            ]
        ]);
    }

    public function respondDeleted($message)
    {
        return $this->respond([
            'success' => [
                'message' => $message
            ]
        ]);
    }

    public function respondInvalidRequest($message = 'Sorry! Required field is missing')
    {
        return $this->setStatusCode(HttpResponse::HTTP_FORBIDDEN)->respondWithError($message);
    }
}
