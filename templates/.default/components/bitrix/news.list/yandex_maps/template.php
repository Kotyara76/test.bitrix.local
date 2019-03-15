<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="news-list">
    <?// todo вынести в параметры родительского компонента?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:map.yandex.view",
        "",
        Array(
            "CONTROLS" => array("ZOOM","MINIMAP","TYPECONTROL","SCALELINE"),
            "INIT_MAP_TYPE" => "MAP",
            "MAP_DATA" => serialize(['PLACEMARKS' => $arResult['PLACEMARKS']]),
            "MAP_HEIGHT" => "500",
            "MAP_ID" => "yandex_map_1",
            "MAP_WIDTH" => "100%",
            "OPTIONS" => array("ENABLE_SCROLL_ZOOM","ENABLE_DBLCLICK_ZOOM","ENABLE_DRAGGING"),
            "ONMAPREADY" => 'fitPlacemarks', // центруем карту по всем точкам
        ),
        $component
    );?>
</div>

