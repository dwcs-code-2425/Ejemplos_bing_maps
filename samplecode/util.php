<?php
function getConfig(string $rutaIniFile = "config.ini")
{
    $proxy_config = parse_ini_file($rutaIniFile, true);
    return $proxy_config;
}


function createStreamContext()
{
    $opts = [
        "http" => [
            "proxy" => getConfig()["proxy"]["proxy_url"],
            "request_fulluri" => true,
        ]
    ];
    $context = stream_context_create($opts);
    return $context;
}
