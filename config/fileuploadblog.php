<?php

    function getAbsoluteUrl($s, $use_forwarded_host = false)
    {
        $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
        $sp = (isset($s['SERVER_PROTOCOL'])) ? strtolower($s['SERVER_PROTOCOL']) : 'http';
        $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
        $port = (isset($s['SERVER_PORT'])) ? $s['SERVER_PORT'] : "80";
        $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
        $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
        if (isset($s['SERVER_NAME'])) {
            $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
        } else {
            $host = isset($host) ? $host : $port;
        }
        return $protocol . '://' . $host;
    }

    $storagePath = storage_path("app/public/uploads");

    return [
        'path' => [
            'upload' => [
                'images' => $storagePath."/images/",
            ],

            'url' => [
                'images' => "/uploads/images/"
            ],
        ],

        "status_codes" => [
            "success" => "200",
            "success_with_empty" => "201",
            "auth_fail" => "401",
            "form_validation" => "422",
            "normal_error" => "403",
            "server_side" => "500",
        ],
    ];