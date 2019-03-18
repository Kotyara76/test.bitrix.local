<?php
namespace Khudyakov\Agents;

use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\DateTime;

class RssNews
{

    const DATE_FORMAT = 'd M Y H:i:s O';
    /**
     * @param $rssUrl - лента новостей
     * @param $iblockId - ID инфоблока для записи
     * @param integer|null $count - количество новостей из ленты
     */
    public static function getLastNews($rssUrl, $iblockId, $count = 1)
    {
        if (Loader::includeModule('iblock')) {

            $parsedUrl = parse_url($rssUrl);
            if (is_array($parsedUrl)) {

                if (isset($parsedUrl["scheme"]))
                    $site = $parsedUrl["scheme"]."://".$parsedUrl["host"];
                else
                    $site = $parsedUrl["host"];

                if (isset($parsedUrl["port"]))
                    $port = $parsedUrl["port"];
                else
                    $port = ($parsedUrl["scheme"] == "https"? 443 : 80);

                $path = $parsedUrl["path"];
                $queryString = $parsedUrl["query"];
            }

            // Используем встроенные методы, чтобы не писать лишний код для парсинга
            $oRss = new \CIBlockRSS();
            $arRss = $oRss->GetNewsEx($site, $port, $path, $queryString);
            $arRss = $oRss->FormatArray($arRss, false);

            if ($count < 1) {
                $count = 1;
            }

            $i = $count;
            $obIblock = new \CIBlockElement();
            foreach ($arRss['item'] as $arItem) {

                $xmlId = md5($arItem['link']); // Хэш, контроль дублей

                if (!\CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId, '=XML_ID' => $xmlId], false, ['nTopCount' => 1], ['ID'])->Fetch()) {

                    if (DateTime::isCorrect($arItem['pubDate'], static::DATE_FORMAT)) {
                        $arItem['pubDate'] = new DateTime($arItem['pubDate'], static::DATE_FORMAT);
                    } else {
                        $arItem['pubDate'] = new DateTime();
                    }

                    $arFields = [
                        'IBLOCK_ID' => $iblockId,
                        'NAME' => $arItem['title'],
                        'XML_ID' => $xmlId,
                        'PREVIEW_TEXT_TYPE' => 'text',
                        'PREVIEW_TEXT' => $arItem['description'],
                        'ACTIVE_FROM' => $arItem['pubDate'],
                        'PROPERTY_VALUES' => [
                            'SRC_URL' => $arItem['link']
                        ],
                    ];

                    if (!$obIblock->Add($arFields)) {
                        Debug::writeToFile($obIblock->LAST_ERROR);
                        // todo логировать ошибки
                    }
                }

                if (--$i <= 0) {
                    break;
                }
            }
        }

        return __METHOD__.'("'.$rssUrl.'", '.$iblockId.', '.$count.')';
    }


}
