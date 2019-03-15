<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arLocations = [];

foreach ($arResult['ITEMS'] as $arItem) {
    if (is_array($arItem['PROPERTIES'][$arParams['LOCATION_PROPERTY_NAME']]) && ($loc = $arItem['PROPERTIES'][$arParams['LOCATION_PROPERTY_NAME']]['VALUE'])) {
        list ($lat, $lon) = explode(',', $loc);
        $arLocations[] = [
            'LON' => $lon,
            'LAT' => $lat,
            'TEXT' => $arItem['NAME']
        ];
    }
}

$arResult['PLACEMARKS'] = $arLocations;
unset($arLocations);

