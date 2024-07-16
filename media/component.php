<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$arDefaultUrlTemplates404 = array(
    // дефолтные url адреса
    "list" => "",
    "add" => "add-element/",
    "detail" => "#ELEMENT_ID#",
);

$arDefaultVariableAliases = array("detail" => array("ELEMENT_ID" => "ID"));
$arDefaultVariableAliases404 = array();

$arComponentVariables = array(
    "ID",
    "ELEMENT_ID",
    "ELEMENT_CODE",
    "add_element"
);

$arVariables = array();

// Если задействован режим с ЧПУ
if ($arParams["SEF_MODE"] === "Y") {

    $engine = new CComponentEngine($this);
    // Объединненный  массив шаблонов дефолтных url адресов с теми, что установлены в параметрах
    $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);
    $arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);
    $componentPage = $engine->guessComponentPath(
    // В переменной $componentPage  Определяется шаблон текущей страницы
        $arParams["SEF_FOLDER"],
        $arUrlTemplates,
        $arVariables,
    );

    // Инициализируются переменные
    CComponentEngine::initComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);

    $arResult = array(
        // Формируется массив $arResult
        "FOLDER" => $arParams["SEF_FOLDER"],
        "URL_TEMPLATES" => $arUrlTemplates,
        "VARIABLES" => $arVariables,
    );

    if (!$componentPage) {
        $componentPage = "list";
    }

} else {
    // иначе не задействован режим с ЧПУ
    $arVariables = array();

    $arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases, $arParams["VARIABLE_ALIASES"]);
    CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);
    $componentPage = "";

    // В переменной $componentPage  Определяется шаблон текущей страницы
    if (isset($arVariables["ID"]) && intval($arVariables["ID"]) > 0) {
        $componentPage = "detail";
    } elseif (isset($_REQUEST["add-element"])) {
        $componentPage = "add";
    } else
        $componentPage = "list";

    $arResult = array(
        "FOLDER" => "",
        "URL_TEMPLATES" => array(
            "list" => htmlspecialcharsbx($APPLICATION->GetCurPage()),
            "detail" => htmlspecialcharsbx($APPLICATION->GetCurPage() . "?" . $arVariableAliases["detail"]["ELEMENT_ID"] . "=#ELEMENT_ID#"),
            "add" => htmlspecialcharsbx($APPLICATION->GetCurPage() . "?add-element=y"),
        ),
        "VARIABLES" => $arVariables,
        "ALIASES" => $arVariableAliases,
    );
}

$this->IncludeComponentTemplate($componentPage);
?>

