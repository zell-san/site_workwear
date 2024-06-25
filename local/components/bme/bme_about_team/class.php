<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('iblock');

class OurTeamMainPage extends  \CBitrixComponent{

    const iblockID = 5;
    protected function getElements(){
        $arElements=array();
        $elements = CIBlockElement::GetList(
            ["SORT"=>"ASC"],
            [
                'IBLOCK_ID'=>$this::iblockID,
                'ACTIVE' => 'Y',

            ],
            false,
            false,
            ["ID","NAME","PREVIEW_PICTURE","PROPERTY_POST"]
        );

        while ($element = $elements->fetch()) {
            $element['PREVIEW_PICTURE'] = CFile::GetPath($element['PREVIEW_PICTURE']);
            $arElements[] = $element;
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