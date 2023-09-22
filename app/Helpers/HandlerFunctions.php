<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

use Carbon\Carbon;

function ResponseJson($info = [], $status = true, $e = '')
{
    if (!$status) {
        return [
            'meta' => [
                'success' => $status,
                'errors' => [],
            ],
            'data' => []
        ];
    }

    return [
        'meta' => [
            'success' => $status,
            'errors' => [],
        ]
    ];
}
