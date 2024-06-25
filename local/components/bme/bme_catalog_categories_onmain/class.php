<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
Loc::loadMessages(__FILE__);
\Bitrix\Main\Loader::includeModule('iblock');

class CatalogCategoriesOnMainPage extends  \CBitrixComponent{

    protected function getCategories(){
        $arSections=array();
        $query = new \Bitrix\Main\Entity\Query(
            \Bitrix\Iblock\Model\Section::compileEntityByIblock(CATALOG_IBLOCK_ID)
        );
        $query
            ->setOrder(array("SORT" => "ASC"))
            ->setFilter(
                array(
                    "IBLOCK_ID" => CATALOG_IBLOCK_ID,
                    "ACTIVE"=>'Y',
                    "UF_SHOW_MAIN"=>1

                )
            )
            ->setSelect(
                array(
                    'ID',
                    'CODE',
                    'NAME',
                    'UF_SHOW_MAIN',
                    'UF_MAIN_ICON',
                    'SECTION_PAGE_URL_RAW' => 'IBLOCK.SECTION_PAGE_URL'

                )
            );

        $result= $query->exec();
        while ( $sec_arr= $result->fetch() ) {
            $sec_arr['SECTION_PAGE_URL']=\CIBlock::ReplaceDetailUrl($sec_arr['SECTION_PAGE_URL_RAW'], $sec_arr, true, 'S');
            $sec_arr['UF_MAIN_ICON_SRC']=CFile::GetPath($sec_arr['UF_MAIN_ICON']);
            $arSections[]=$sec_arr;
        }
        return $arSections;
    }

    public function executeComponent()
    {
        $this->arResult['SECTIONS'] = $this->getCategories();
        $this->includeComponentTemplate();
    }
}

?>