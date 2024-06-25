<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Application;
use \Bitrix\Main\Localization\Loc;

?>

<? if (!empty($arResult)): ?>
    <section class="container section">
        <div class="row">
            <div class="col s12 team-title">
                <h2>Наша команда</h2>
                <div class="border-line red darken-1"></div>
            </div>
        </div>
        <div class="row team-row">
            <? foreach ($arResult['ITEMS'] as $id => $arrItem): ?>
                <div class="col s12 m6 xl4 d-flex-center team-col">
                    <div class="circle team-circle-box z-depth-1 hoverable">
                        <img src="<?= $arrItem['PREVIEW_PICTURE'] ?>" alt="" class="responsive-img">
                    </div>
                    <h6 class="center-align team-name"><?= $arrItem['NAME'] ?></h6>
                    <span><?= $arrItem['PROPERTY_POST_VALUE'] ?></span>
                </div>
            <? endforeach; ?>
        </div>
    </section>
<? endif; ?>
