<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class mediaListComponents extends CBitrixComponent
{
    function elementsGetList()
    {
        // выборка всего списка элементов по ID инфоблока
        $arFilter = [
            "IBLOCK_ID" => $this->arParams["IBLOCK_ID"],
            "ACTIVE" => "Y",
        ];
        $arSelect = ["IBLOCK_ID", "ID", 'NAME', 'PREVIEW_TEXT', 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL', 'DETAIL_URL'];
        $resDb = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        $resDb->SetUrlTemplates($this->arParams["DETAIL_URL"]);
        while ($res = $resDb->GetNext()) {
            $this->arResult[$res['ID']] = $res;
        }
        ?>
        <script>
            (function () {
                document.addEventListener('DOMContentLoaded', function () {
                    const uiBtnMain = document.querySelectorAll('.ui-btn-main');
                    const url = '<?=$this->GetPath() . '/ajax.php';?>';
                    const iblock = '<?=$this->arParams["IBLOCK_ID"]?>';
                    uiBtnMain.forEach((item) => {
                        item.addEventListener('click', () => {
                            AJAXDelElement(item.getAttribute('data-del'));
                        })
                    });

                    function AJAXDelElement(id) {
                        BX.ajax.post(
                            url,
                            {
                                id: id,
                                iblock: iblock,
                            },
                            function callback(data) {

                                if (data !== null) {

                                    const dataObj = JSON.parse(data);
                                    if(dataObj.ok) {
                                        const delItem = document.getElementById(dataObj.ok);
                                        delItem.remove();
                                    }
                                    if(dataObj.err) {
                                       console.log('Элемент с ID: ' + dataObj.err + ' не найден');
                                    }

                                }
                            }
                        )
                    }
                });
            })();
        </script>
        <?php
    }

    public
    function executeComponent()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock')) {
            return;
        }
        if ($this->arParams['IBLOCK_ID'] > 0 && $this->StartResultCache(false)) {
            $this->elementsGetList();
            $this->IncludeComponentTemplate();
        } else {
            $this->AbortResultCache();
        }
    }
}
