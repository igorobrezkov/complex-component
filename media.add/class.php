<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class mediaAddComponents extends CBitrixComponent
{
    private
    function formValidation(): void
    {
        ?>
        <script>
            (function () {
                document.addEventListener('DOMContentLoaded', function () {

                    const formTite = document.querySelector('.form__title');
                    const url = '<?=$this->GetPath() . '/ajax.php';?>';
                    const iblockId = '<?=$this->arParams['IBLOCK_ID']?>';
                    const uiCtlElement = document.querySelector('.ui-ctl-element--name')
                    const uiAlertName = document.querySelector('.ui-alert-name');
                    const uiCtlElementText = document.querySelector('.ui-ctl-element--text');
                    const uiAlertText = document.querySelector('.ui-alert-text')
                    const uiBtn = document.querySelector('.ui-btn--start');
                    const uiCtlElementFile = document.querySelector('.ui-ctl-element--file');
                    let objForm = {};
                    let imgTmpPath = '';

                    function getObjForm() {
                        return objForm = {
                            'name': uiCtlElement.value,
                            'text': uiCtlElementText.value,
                            'iblock': iblockId,
                            'images': imgTmpPath,
                        };
                    }

                    uiCtlElementFile.addEventListener('change', () => {
                        // при событии загрузки файла отправляем запрос на получения пути файла
                        const form = document.querySelector('.form');
                        const formData = new FormData(form);
                        const bxFormData = new BX.ajax.FormData();
                        for (let [name, value] of formData) {
                            bxFormData.append(name, value);
                        }
                        bxFormData.send(
                            url + '?img',
                            function (data) {
                                imgTmpPath = JSON.parse(data).images
                            },
                            null,
                            function (error) {
                                console.log(`error: ${error}`)
                            }
                        );
                    });
                    uiBtn.addEventListener('click', (e) => {
                        e.preventDefault();

                        if (uiCtlElement.value === '' || uiCtlElementText.value === '') {
                            if (uiCtlElement.value === '') {
                                uiAlertName.textContent = 'Поле Назввание обязательно для заполнения';
                            }
                            if (uiCtlElementText.value === '') {
                                uiAlertText.textContent = 'Поле Краткое орисание обязательно для заполнения'
                            }
                        } else {
                            AJAXLoad(); // запуск функции по отправке данных с помощью AJAX на сервер для добавления записи в инфоблок
                        }
                    });

                    uiCtlElement.addEventListener('focus', () => {
                        uiAlertName.innerHTML = '';
                    });

                    uiCtlElementText.addEventListener('focus', () => {
                        uiAlertText.innerHTML = '';
                    })

                    function AJAXLoad() {

                        BX.ajax({
                            url: url,
                            method: 'POST',
                            type: "POST",
                            data: getObjForm(),
                            dataType: 'json',

                            onsuccess: function (data) {
                                if (data !== null) {
                                    let entries = Object.entries(data);
                                    for (let [key, val] of entries) {
                                        switch (key) {
                                            case 'errorText':
                                                uiAlertText.innerHTML = val;
                                                break;
                                            case 'eddElement':
                                                formTite.innerHTML = val;
                                                break;
                                        }
                                    }
                                }
                            },

                            onfailure: function (data) {
                                console.log('Что то  пошло не так');
                            },
                        });
                    }
                });
            })();
        </script>
        <?php
    }

    public
    function executeComponent(): void
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock')) {
            return;
        }
        if ($this->arParams['IBLOCK_ID'] > 0 && $this->StartResultCache(false)) {
            $this->formValidation();
            $this->IncludeComponentTemplate();
        } else {
            $this->AbortResultCache();
        }
    }

}

