<?php

use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Storage;


function apiResponse($errorCode, $errormessage, $data = null,$http_status_code = 200)
{
    $response = [
        'errorcode' => $errorCode,
        'errormessage' => $errormessage,
    ];

    if ($data !== null) {
        $response['data'] = $data;
    }

    return response()->json($response,$http_status_code);
}

function generatePaginationData($result)
{
    return [
        'total' => $result->total(),
        'per_page' => $result->perPage(),
        'current_page' => $result->currentPage(),
        'last_page' => $result->lastPage(),
        'from' => $result->firstItem(),
        'to' => $result->lastItem()
    ];
}