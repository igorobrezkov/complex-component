<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    return;
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = array();
$rsIBlock = CIBlock::GetList(array("sort" => "asc"), array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE" => "Y"));
while ($arr = $rsIBlock->Fetch()) {
    $arIBlock[$arr["ID"]] = "[" . $arr["ID"] . "] " . $arr["NAME"];
}


$arComponentParameters = array(

    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlockType,
            "REFRESH" => "Y",
        ),
        "IBLOCK_CODE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("BN_P_IBLOCK"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlock,
            "REFRESH" => "Y",
            "ADDITIONAL_VALUES" => "Y",
        ),
        "VARIABLE_ALIASES" => array(
            "ELEMENT_ID" => array("NAME" => GetMessage("ELEMENT_ID_DESC")),
        ),
        "SEF_MODE" => array(
            "list" => array(
                "NAME" => GetMessage("T_IBLOCK_SEF_PAGE_LIST"),
                "DEFAULT" => "",
                "VARIABLES" => array(),
            ),
            "add" => array(
                "NAME" => GetMessage("T_IBLOCK_SEF_PAGE_ADD"),
                "DEFAULT" => "add-element/",
                "VARIABLES" => array(),

            ),
            "detail" => array(
                "NAME" => GetMessage("T_IBLOCK_SEF_PAGE_EDIT"),
                "DEFAULT" => "#ELEMENT_CODE#/",
                "VARIABLES" => array(
                    "ID"
                ),
            )
        ),
        "CACHE_TIME" => array("DEFAULT" => 36000000),
    ),
);

?>
