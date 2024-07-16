<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$this->setFrameMode(true);
?>
<a class="ui-btn ui-btn-primary" href="<?=$arParams["BACK_LIST"] ?>"> <?= Loc::getMessage('CT_BACK_LINK') ?></a>
<div class="container__detail">
    <h2><?= $arResult[0]['NAME'] ?></h2>
    <p><?= $arResult[0]['PREVIEW_TEXT'] ?></p>
    <? if ($arResult[0]['PREVIEW_PICTURE']): ?>
        <img src="<?= CFile::GetPath($arResult[0]['PREVIEW_PICTURE']) ?>">
    <? endif; ?>
</div>

