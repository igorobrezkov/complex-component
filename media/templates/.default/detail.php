<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?$APPLICATION->IncludeComponent(
    "media:media.detail",
    "media-detail",
    Array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "ELEMENT_ID" => ($_REQUEST["ID"]) ? $_REQUEST["ID"] : '',
        "IBLOCK_ID" => $arParams["IBLOCK_CODE"],
        "CODE" => ($arResult["VARIABLES"]["ELEMENT_CODE"]) ? $arResult["VARIABLES"]["ELEMENT_CODE"] : '',
        "BACK_LIST" => $arParams["SEF_FOLDER"],
        "DETAIL_URL" => ""
    ),
    $component
);?>

