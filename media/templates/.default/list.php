<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? $APPLICATION->IncludeComponent(
    "media:media.list",
    "media-list",
    array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID" => $arParams["IBLOCK_CODE"],
        "DETAIL_URL" => ($arResult["FOLDER"] != '') ? $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"] : $arResult["URL_TEMPLATES"]["detail"],
        "ADD_LINK" => $arResult["URL_TEMPLATES"]["add"],
    ),
    $component
); ?>