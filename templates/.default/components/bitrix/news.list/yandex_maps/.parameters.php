<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Iblock\PropertyTable;

$arPropertyMap = array();

CModule::IncludeModule('iblock');

if (!empty($arCurrentValues['IBLOCK_ID']) && (int)$arCurrentValues['IBLOCK_ID'] > 0)
{
    $propertyIterator = PropertyTable::getList([
        'select' => ['ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE', 'MULTIPLE', 'LINK_IBLOCK_ID', 'USER_TYPE', 'SORT'],
        'filter' => ['=IBLOCK_ID' => $arCurrentValues['IBLOCK_ID'], '=USER_TYPE' => 'map_yandex', '=ACTIVE' => 'Y'],
        'order' => ['SORT' => 'ASC', 'NAME' => 'ASC']
    ]);
    while ($property = $propertyIterator->fetch()) {
        $propertyCode = (string)$property['CODE'];
        if ($propertyCode == '')
            $propertyCode = $property['ID'];
        $arPropertyMap[$propertyCode] = '['.$propertyCode.'] '.$property['NAME'];
    }
    unset($propertyCode, $property, $propertyIterator);
}
$arTemplateParameters = array(
	"DISPLAY_DATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_DATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_NAME" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_NAME"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PICTURE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_PICTURE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
	"DISPLAY_PREVIEW_TEXT" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_TEXT"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
    "LOCATION_PROPERTY_NAME" => array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => GetMessage("T_IBLOCK_MAP_PROPERTY"),
        "TYPE" => "LIST",
        "MULTIPLE" => "N",
        "ADDITIONAL_VALUES" => "Y",
        "VALUES" => $arPropertyMap,
		"DEFAULT" => (count($arPropertyMap) == 1) ? current(array_keys($arPropertyMap)) : null,
    ),
);
?>
