<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Application;
use \Bitrix\Main\Localization\Loc;

?>
<?if(!empty($arResult)):?>
<section class="container">
        <div class="section pb-l-0">
            <div class="row">
                <div class="col s12">
                    <h2>Если закажете у нас, то мы</h2>
                    <div class="border-line red darken-1"></div>
                </div>
            </div>
            <div class="row advantages-none">
                <?foreach ($arResult['ITEMS'] as $id=>$arrItem):?>
                    <?if($id===count($arResult['ITEMS'])-1):?>
                        <?$color='red';?>
                    <?else:?>
                        <?$color='blue';?>
                    <?endif;?>
                    <div class="col s6 xl4 xxl3">
                        <div class="advantages-square z-depth-1 hoverable <?=$color?> darken-3 white-text valign-wrapper">
                            <h6 class="advantages-square-text"><?=$arrItem['PREVIEW_TEXT']?></h6>
                        </div>
                    </div>
                <?endforeach;?>
            </div>


            <div id="carousel4" class="carousel carousel-advantages advantages-block">
                <?foreach ($arResult['ITEMS'] as $id=>$arrItem):?>
                    <?if($id===count($arResult['ITEMS'])-1):?>
                        <?$color='red';?>
                    <?else:?>
                        <?$color='blue';?>
                    <?endif;?>
                    <div class="carousel-item">
                        <div class="advantages-square z-depth-1 hoverable <?=$color?> darken-3 white-text valign-wrapper">
                            <h6 class="advantages-square-text"><?=$arrItem['PREVIEW_TEXT']?></h6>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </section>
<?endif;?>