<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

class delItem
{
    function __construct()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock'))
            return;

        $this->starDel();
    }

    private function starDel(): void
    {
        if (isset($_POST['id']) && $_POST['id'] != '') {

            if ($this->checkError($_POST['id']) !== null) {
                CIBlockElement::Delete($_POST['id']);
                echo json_encode(['ok' => $_POST['id']]);
            } else {
                echo json_encode(['err' => $_POST['id']]);
            }

        }
    }

    private function checkError(string $id): ?string
    {
        $arFilter = [
            'ID' => intval($id),
            'IBLOCK_ID' => $_POST['iblock']
        ];
        $arSelect = ["ID", "IBLOCK_ID"];
        $resDB = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        if ($res = $resDB->GetNext()) {
            $arRes['ID'] = $res['ID'];
        }
        return $arRes['ID'];
    }
}

$delItem = new delItem();

