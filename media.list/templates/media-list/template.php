<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$this->addExternalCss("/bitrix/css/main/bootstrap_v4/bootstrap.min.css");
$this->setFrameMode(true);
?>

<div class="container-fluid list">
    <a class="ui-btn ui-btn-primary" href="<?= $arParams["ADD_LINK"] ?>"> <?= Loc::getMessage('CT_ADD_LINK') ?> </a>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Название</th>
            <th scope="col">Краткое лписание</th>
            <th scope="col">Картинка</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($arResult

        as $KeyItem => $alItem): ?>
        <? if ($KeyItem): ?>
        <tr id="<?= $alItem['ID'] ?>"><? endif; ?>
            <td><?= $alItem['ID'] ?></td>
            <td>
                <a href="<?= $alItem['DETAIL_PAGE_URL'] ?>">
                    <?= $alItem['NAME'] ?>
                </a>
            </td>
            <td><?= $alItem["PREVIEW_TEXT"] ?></td>
            <td class="flex">
                <span style="margin-right: 10px">
                    <? if ($alItem['PREVIEW_PICTURE'] !== null): ?>
                        <img width="150"
                             src="<?= CFile::GetPath($alItem['PREVIEW_PICTURE']) ?>"
                             alt="">
                    <? else: ?>
                        <img width="150" src="<?= $this->GetFolder() ?>/images/no_image.jpg" alt="">
                    <? endif ?>
                </span>
                <div class="ui-btn-split ui-btn-danger">
                    <button class="ui-btn-main" data-del="<?= $alItem['ID'] ?>"> Удалить</button>
                </div>
            </td>
            <? endforeach; ?>
        </tbody>
    </table>
</div>