<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Application;
use \Bitrix\Main\Localization\Loc;

?>
<?if(!empty($arResult)):?>
    <div class="section">
        <div class="row">
            <?foreach ($arResult['SECTIONS'] as $arrSect):?>
                <a class="col s6 m4 l2" href="<?=$arrSect['SECTION_PAGE_URL']?>">
                    <div class="catalog-box z-depth-1 hoverable blue darken-3 pointer">
                        <div class="catalog-img catalog-img-large">
                            <img src="<?=$arrSect['UF_MAIN_ICON_SRC']?>" ></div>
                    </div>
                    <p class="center black-text pointer"><?=$arrSect['NAME']?></p>
                </a>
            <?endforeach;?>
        </div>
    </div>
<?endif;?>