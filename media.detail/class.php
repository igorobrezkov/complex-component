<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class mediaDetailComponents extends CBitrixComponent
{
    private
    function elementDetail(): void
    {
        $arFilter = [
            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
            "ID" => $this->arParams["ELEMENT_ID"],
            "CODE" => $this->arParams["CODE"],
            "ACTIVE" => "Y",
        ];
        $arSelect = ["IBLOCK_ID", "ID", 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE'];
        $resDb = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while ($res = $resDb->GetNext()) {
            $this->arResult[] = $res;
        }

    }

    public
    function executeComponent(): void
    {
        if (!Bitrix\Main\Loader::includeModule('iblock')) {
            return;
        }
        if ($this->arParams['IBLOCK_ID'] > 0 && $this->StartResultCache(false)) {
            $this->elementDetail();
            $this->IncludeComponentTemplate();
        } else {
            $this->AbortResultCache();
        }
    }

}

