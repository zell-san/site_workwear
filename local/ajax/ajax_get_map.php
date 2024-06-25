<?
define("PULL_AJAX_INIT", true);
define("PUBLIC_AJAX_MODE", true);
define("NO_KEEP_STATISTIC", "Y");
define("NO_AGENT_STATISTIC", "Y");
define("NO_AGENT_CHECK", true);
define("NOT_CHECK_PERMISSIONS", true);
define("DisableEventsCheck", true);
define('STOP_STATISTICS', true);
define('BX_CRONTAB_SUPPORT', true);
define('YT_NO_INCLUDE_OLD_CORE', 'Y');
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
$MAP_DATA=Array
(
    "yandex_lat" =>$_REQUEST['lat'], // первая координата (Широта)
    "yandex_lon" => $_REQUEST['lon'], // вторая координата (Долгота)
    "yandex_scale" => "16",
    "PLACEMARKS" => [
        ['TEXT' => $_REQUEST['text'],
        'LON' => $_REQUEST['lon'],
        'LAT' => $_REQUEST['lat']
            ]
    ]
);

$APPLICATION->IncludeComponent(
    "bitrix:map.yandex.view",
    "bme_map",
    Array(
        'KEY' => '88d5590e-8a54-4b90-8266-59378f67866f',
        "INIT_MAP_TYPE" => "MAP",
        "MAP_DATA" =>serialize($MAP_DATA),
        "MAP_WIDTH" => "100%",
        "MAP_HEIGHT" => "625",
        "CONTROLS" => array(0=>"ZOOM",1=>"SMALLZOOM",),
        "OPTIONS" => array(0=>"ENABLE_DBLCLICK_ZOOM",1=>"ENABLE_DRAGGING",),
        "MAP_ID" =>$_REQUEST['map_id']
    )
);?>