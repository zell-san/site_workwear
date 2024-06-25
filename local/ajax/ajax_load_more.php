<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Iblock\PropertyIndex\Facet;

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

Loader::includeModule('iblock');
Loader::includeModule('catalog');
$request = Application::getInstance()->getContext()->getRequest();
$url = explode('?',$request->get('url'));
$facet=$request->get('facet');
$aFilterParams=explode('&',$url[1]);
$aCustomfilter=[];
$aFilter=[
    'IBLOCK_ID' => CATALOG_IBLOCK_ID,
    'ACTIVE' => 'Y',
];
//echo '<pre>';
//print_r($facet);
//echo '</pre>';

foreach ($aFilterParams as $param){
    $temp=explode('=',$param);
    if(!in_array($temp[0],['set_filter','clear_cache','sortby']))
    {

        $filterId=explode('_',$temp[0]);
        $aCustomfilter[$filterId[1]]=$temp[1];
        $res = CIBlockProperty::GetByID($filterId[1], CATALOG_IBLOCK_ID, "catalog");
        if($ar_res = $res->GetNext())
            $aFilter['PROPERTY_'.strtoupper ($ar_res['CODE']).'_VALUE']=$facet[$temp[0]];
    }
}

$id = (int)$request->get('id')!==0?(int)$request->get('id'):false;
$sortField_1 = $request->get('sortField_1');
$sortField_2 = $request->get('sortField_2');
$sortFieldOrder_1 = $request->get('sortFieldOrder_1');
$sortFieldOrder_2 = $request->get('sortFieldOrder_2');
$currPage = (int)$request->get('currPage');
$totalPageCount = (int)$request->get('totalPageCount');


$pageNumber=$currPage;
$curPage = $APPLICATION->GetCurPage();
$isActionSection = $curPage === '/catalog/';
$arWaterMark = array(
    array(
        "name" => "watermark",
        "position" => "br", // Положение
        "type" => "image",
        "size" => "real",
        "file" => $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . '/src/img/watermark2.png', // Путь к картинке
        "fill" => "exact",
    )
);
$aSort = [$sortField_1 => $sortFieldOrder_1, $sortField_2 => $sortFieldOrder_2];

if($id!==false){
    $aFilter['SECTION_ID']=$id;
}
else{
    $aFilter['PROPERTY_ACTION_VALUE']='Y';
}
//echo '<pre>';
//print_r($aFilter);
//echo '</pre>';
$elements = CIBlockElement::GetList(
    $aSort ,
    $aFilter,
    false,
    [
        'iNumPage' => $pageNumber,
        'nPageSize' => 12
    ],
    [
        'ID',
        'IBLOCK_ID',
        'IBLOCK_SECTION_ID',
        'NAME',
        'PROPERTY_ACTION',
        'PROPERTY_NEW',
        'PROPERTY_minpromtorg',
        'PROPERTY_PRICE',
        'PROPERTY_NEW_PRICE',
        'PROPERTY_SEX',
        'DETAIL_PICTURE',
        'PREVIEW_PICTURE',
        'DETAIL_PAGE_URL'
    ]
);

while ($element = $elements->GetNext()) {

    $img = \CFile::ResizeImageGet(
        $element['DETAIL_PICTURE'],
        array("width" => 1320, "height" => 1980),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true,
        $arWaterMark
    );
    $element['DETAIL_PICTURE'] = $img['src'];

    $img = \CFile::ResizeImageGet(
        $element['PREVIEW_PICTURE'],
        array("width" => 1320, "height" => 1980),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true,
        $arWaterMark
    );
    $element['PREVIEW_PICTURE'] = $img['src'];

    $arElements[] = $element;
}

?>
<? foreach ($arElements as $arItem): ?>
    <div class="col s12 m6 xl4 <? if ($isActionSection): ?>grid-item-catalog<? endif; ?>">
        <div class="card sticky-action divide-card">
            <div class="card-image grey lighten-2">
                <?/* if ($arItem['PROPERTY_ACTION_VALUE'] == "Y"): ?>
                    <span class="badge red darken-1 white-text divide-card__badge">Скидка</span>
                <? endif; ?>
                <? if ($arItem['PROPERTY_NEW_VALUE'] == "Y"): ?>
                    <span class="badge blue darken-3 white-text divide-card__badge-l">Новинка</span>
                <? endif; */?>
                <? if ($arItem['PROPERTY_minpromtorg_VALUE_XML_ID'] == 'Y'): ?>
                    <span class="badge minpromtorg divide-card__badge-m"></span>
                <? endif; ?>
                <a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="divide-card-img">
                    <? if (!empty($arItem['DETAIL_PICTURE'])): ?>
                        <img class="divide-card-img-hover-hide" src="<?= $arItem['PREVIEW_PICTURE'] ?>">
                        <img class="divide-card-img-hover-show" src="<?= $arItem['DETAIL_PICTURE'] ?>">
                    <? else: ?>
                        <img src="<?= $arItem['PREVIEW_PICTURE'] ?>">
                    <? endif; ?>
                </a>
            </div>
            <div class="card-content">
                <span class="card-title activator grey-text text-darken-4">
                    <?= $arItem['NAME'] ?>
                    <i class="material-icons right">more_vert</i>
                </span>
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">
                    <?= $arItem['NAME'] ?>
                    <i class="material-icons right">close</i>
                </span>
                <p><?= $arItem['PREVIEW_TEXT'] ?></p>
            </div>
            <? $price = $arItem['PROPERTY_PRICE_VALUE']; ?>
            <? $newPrice = $arItem['PROPERTY_NEW_PRICE_VALUE'] ?>

            <div class="card-action center">
                <? if (empty($newPrice)): ?>
                    <? if (!empty($price)): ?>
                        <span class="blue-text text-darken-3"><?= $price . " руб." ?></span>
                    <? else: ?>
                        <span class="blue-text text-darken-3">Цена не указана</span>
                    <? endif; ?>
                <? else: ?>
                    <span class="blue-text text-darken-3"><?= $newPrice . " руб." ?></span>
                    <span class="grey-text old-price-prev"><?= $price . " руб." ?></span>
                <? endif; ?>
            </div>
        </div>
    </div>
<? endforeach; ?>

