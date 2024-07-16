<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$this->setFrameMode(true);
?>
    <a class="ui-btn ui-btn-primary" href="<?=$arParams["BACK_LIST"] ?>"> <?= Loc::getMessage('CT_BACK_LINK') ?></a>
    <form class="form" enctype="multipart/form-data"  method="post">
        <h2 class="form__title">Форма добавления элемента в инфоблок</h2>
        <div style="margin-bottom: 25px" class="ui-ctl ui-ctl-textbox  ui-ctl-w50">
            <div class="ui-ctl-tag ui-ctl-tag-warning">обязательное</div>
            <input type="text" class="ui-ctl-element ui-ctl-element--name" placeholder="Название" required>
            <div class="ui-alert">
                <span class="ui-alert-message ui-alert-xs ui-alert-name"></span>
            </div>
        </div>
        <div style="margin:0 0 65px 0" class="ui-ctl ui-ctl-textarea ui-ctl-w50">
            <div class="ui-ctl-tag ui-ctl-tag-warning">обязательное</div>
            <textarea class="ui-ctl-element ui-ctl-element--text" placeholder="Краткое описание" required></textarea>
            <div class="ui-alert">
                <span class="ui-alert-message ui-alert-xs ui-alert-text"></span>
            </div>
        </div>
        <label style="margin-bottom: 25px; margin-left: 0" class="ui-ctl ui-ctl-file-btn">
            <div class="ui-ctl-label-text">Добавить изображение аноннса
                <input type="file" class="ui-ctl-element ui-ctl-element--file" name="media_file" >
            </div>
        </label>
        <div class="ui-btn-lg">
            <input type="submit" class="ui-btn ui-btn-primary ui-btn--start" name="upload" value="Добавить элемент в инфоблок">
        </div>
    </form>
