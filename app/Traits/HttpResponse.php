<?php

namespace App\Traits;

trait HttpResponse
{
    public static function success($message): \Illuminate\Http\Response
    {
        return response([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    public static function failure($message, $status): \Illuminate\Http\Response
    {
        return response([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public static function returnData($key, $value, $pagination = false, $message = ""): \Illuminate\Http\Response
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (is_array($key) && is_array($value)) {
            for ($i = 0; $i < sizeof($key); $i++) {
                $response[$key[$i]] = $value[$i];
            }
        } else {
            $response[$key] = $value;
        }

        if ($pagination === true) {
            if (is_array($value))
                $value = $value[0];
            $response['pagination'] = self::pagination_collection($value);

        } elseif ($pagination != false) {
            if (is_array($value))
                $value = $value[0];
            $response['pagination'] = self::pagination_collection($value);
        }


        return response($response, 200);
    }

    public static function pagination_collection($collection)
    {
        return [
            'current_page' => $collection->currentPage(),
            'next_page_url' => $collection->nextPageUrl(),
            'prev_page_url' => $collection->previousPageUrl(),
            'first_page_url' => $collection->url(1),
            'last_page_url' => $collection->url($collection->lastPage()),
            'per_page' => $collection->perPage(),
            'total' => $collection->total(),
        ];
    }
}
