<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", array("formHandler", "OnAfterIBlockElementAddHandler")); // обработчик события после добавления элемента

use \Bitrix\Main\Application;

if (!\Bitrix\Main\Loader::includeModule('iblock'))
    return;

class formHandler
{
    const  TMP_DIR = '/upload/media_tmp/';

    public function __construct()
    {
        if (!file_exists($_SERVER["DOCUMENT_ROOT"] . self::TMP_DIR)) {
            mkdir($_SERVER["DOCUMENT_ROOT"] . self::TMP_DIR); // создаем временную папку /upload/media_tmp/
        }
        if (isset($_REQUEST['img'])) {
            $this->handlerAjaxImg();
        } else {
            $this->handlerAjaxElement();
        }
    }

    private function handlerAjaxImg(): void
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $files = $request->getFileList()->toArray();
        if ($files['media_file']['tmp_name']) {
            // если файл был загружен во временную папку сервера  и не создана  временнуая папка /upload/media_tmp/
            copy($files['media_file']['tmp_name'], $_SERVER["DOCUMENT_ROOT"] . self::TMP_DIR . $files['media_file']['name']); // копируем файл из временной папки сервера во временуую папку /upload/media_tmp/
            echo json_encode(['images' => $_SERVER["DOCUMENT_ROOT"] . self::TMP_DIR . $files['media_file']['name']]); //создаем json с путем файла для клиента
        }
    }

    private function handlerAjaxElement(): void
    {
        if (isset($_POST['name']) && (isset($_POST['text']) && iconv_strlen($_POST['text']) >= 10)) {
            // если из формы пришли данные для создания
            $el = new CIBlockElement; // объект класса для работы с элементами инфоблока
            $code = $el->createMnemonicCode(array('NAME' => $_POST['name'], 'IBLOCK_ID' => $_POST["iblock"], 'ID' => null), array('CHECK_SIMILAR' => 'Y'));
            $el->Add(array(
                // добавлыем новый элемент в инфоблок
                "IBLOCK_ID" => $_POST["iblock"],
                "NAME" => $_POST['name'],
                "PREVIEW_TEXT" => $_POST['text'],
                "CODE" => $this->chechCode($this->translit_sef($_POST['name'])), // генерация символьного кода с проверкой на уникальность
                "PREVIEW_PICTURE" => CFile::MakeFileArray($_POST['images']),
            ));

            if (file_exists(self::TMP_DIR)) {
                //если файл был передан для загрузки, то после загрузки временная папка в upload очищается
                $this->cleanImg(self::TMP_DIR);
            }

        } elseif (isset($_POST['text']) && iconv_strlen($_POST['text']) < 10) {
            // Если минимальная длина текста меньше 10 символов, то возвращается ошибка
            echo json_encode(['errorText' => 'минимальная длина текста меньше 10 символов']);
        }
    }

    private function cleanImg(string $dir): void
    {
        // удаляются картинки из временной папки /upload/media_tmp/ и  сама папка
        $dir = $_SERVER["DOCUMENT_ROOT"] . $dir;
        $di = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
        $ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($ri as $file) {
            $file->isDir() ? rmdir($file) : unlink($file);
        }
    }

    private function translit_sef(string $value): string
    {
        // функция переведет в транслит название для поля Символьный код
        $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
            'е' => 'e', 'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
            'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
            'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
            'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        );

        $value = mb_strtolower($value);
        $value = strtr($value, $converter);
        $value = mb_ereg_replace('[^-0-9a-z]', '-', $value);
        $value = mb_ereg_replace('[-]+', '-', $value);
        $value = trim($value, '-');

        return $value;
    }

    function chechCode(string $code): string
    {
        // Функция проверяет уникальность символьного кода
        $errCode['CODE'] = null;
        $arFilter = [
            "IBLOCK_ID" => $_POST["iblock"],
            "CODE" => $code,
        ];
        $arSelect = ['ID', "IBLOCK_ID", 'CODE'];
        $resDb = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
        while ($res = $resDb->fetch()) {
            $errCode["CODE"] = $res['CODE'];
        }

        if ($errCode["CODE"] === $code) {
            // Если в системе есть элемент с аналогичным символным кодом
            $this->chechCode($code .= "_" . rand(1, 99)); // подставляется рандомное число и рекурсивно запускается проверка
        }
        return $code;
    }

    public static function OnAfterIBlockElementAddHandler(&$arFields): void
    {
        if ($arFields["ID"] > 0)
            echo json_encode(['eddElement' => "Запись с ID " . $arFields["ID"] . " добавлена"]);
    }

}

$ajax = new formHandler();

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");
die();

?>

