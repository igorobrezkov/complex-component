<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if($arParams['IBLOCK_ID'] > 0  && $this->StartResultCache(false))
{
    if(!CModule::IncludeModule("iblock"))
    {
        $this->AbortResultCache();
        ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
        return;
    }

    // выборка всего списка элементов по ID инфоблока
    $arFilter = [
        "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
    ];
    $arSelect = ["IBLOCK_ID", "ID", 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE'];
    $resDb = CIBlockElement::GetList(array('ID' => 'asc'), $arFilter, false, false, $arSelect);
    while ($res = $resDb->GetNext()) {
        $arResult[$res['ID']] = $res;
    }
    echo "<pre>";
    var_dump($arResult);
    echo "</pre>";

    $this->SetResultCacheKeys(array());
    $this->IncludeComponentTemplate();
}
else
{
    $this->AbortResultCache();
}
?>

