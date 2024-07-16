<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("IBLOCK_ELEMENTS_NAME"),
	"DESCRIPTION" => GetMessage("T_IBLOCK_DESC_LIST"),
	"ICON" => "images/list_iblock.gif",
	"COMPLEX" => "Y",
    "SORT" => 10,
    "PATH" => array(
        "ID" => GetMessage("ID_GROUP_COMPONENTS"),
    ),
);

?>