<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? $APPLICATION->IncludeComponent(
// подключается компонент добавления формы
    "media:media.add",
    "media-add",
    array(
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "IBLOCK_ID" => $arParams["IBLOCK_CODE"],
        "BACK_LIST" => ($arParams["SEF_FOLDER"]) ? $arParams["SEF_FOLDER"] : $APPLICATION->GetCurPage(),
    ),
    $component
); ?>

