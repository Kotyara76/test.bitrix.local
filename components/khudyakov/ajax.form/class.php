<?php
namespace Khudyakov\Components;

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;

class AjaxForm extends \CBitrixComponent
{

    function executeComponent()
    {

        if (!Loader::includeModule('iblock')) {
            ShowError('Не подключен модуль iblock');
            return;
        }

        if (!$this->arParams['IBLOCK_ID']) {
            ShowError('Не задан ID инфоблока');
            return;
        }

        if (!$this->arParams['FORM_ID']) {
            $this->arParams['FORM_ID'] = 'form_'.$this->randString();
        }

        // Значения по-умолчанию
        $this->arResult['values'] = [
            'name' => '',
            'description' => '',
        ];


        $this->arResult['error'] = '';
        $this->arResult['success'] = '';

        if ($this->request->isPost() && check_bitrix_sessid()) {

            foreach ($this->arResult['values'] as $key => &$val) {
                $val = $this->request->getPost($key);
            }
            unset($val);

            // тут делаем сто-то с данными формы, например, сохраняем в IB

            $obIblockElement = new \CIBlockElement();
            $res = $obIblockElement->Add([
                'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                'NAME' => $this->arResult['values']['name'],
                'PREVIEW_TEXT' => $this->arResult['values']['description'],
                'PREVIEW_TEXT_TYPE' => 'text',
            ]);

            if (!$res) {
                $this->arResult['error'] = ($this->arParams['ERROR_MESSAGE']) ?: strip_tags($obIblockElement->LAST_ERROR);
            } else {
                $this->arResult['success'] = ($this->arParams['SUCCESS_MESSAGE']) ?: 'Форма сохранена';
            }

            // Если AJAX - возвращаем JSON
            if ($this->request->isAjaxRequest()) {
                die(Json::encode($this->arResult));
            }
        }

        // Устанавливаем заголовок из параметров
        if (strlen($this->arParams['FORM_TITLE'])) {
            global $APPLICATION;
            $APPLICATION->SetTitle($this->arParams['FORM_TITLE']);
        }

        $this->includeComponentTemplate();
    }

    public function onPrepareComponentParams($arParams)
    {
        $arParams['IBLOCK_ID'] = intval($arParams['IBLOCK_ID']);
        return $arParams;
    }
}