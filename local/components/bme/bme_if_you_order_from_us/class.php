<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('iblock');

class IfYouOrderFromUsElementsOnMainPage extends  \CBitrixComponent{

    const iblockID = 10;
    protected function getElements(){
        $arElements=array();
        $elements =  Bitrix\Iblock\ElementTable::getList(
            [
            'order' => ['SORT' => 'ASC'],
            'select' => ['ID', 'IBLOCK_ID', 'NAME', 'PREVIEW_TEXT'],
            'filter' => ['IBLOCK_ID'=>$this::iblockID, 'ACTIVE'=>'Y'],

            ]);

            while($element=$elements->fetch())
            {
                $arElements[]=$element;
            }
            return $arElements;
    }

    public function executeComponent()
    {
        $this->arResult['ITEMS'] = $this->getElements();
        $this->includeComponentTemplate();
    }
}

?>