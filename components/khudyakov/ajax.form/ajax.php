<?php
define('STOP_STATISTICS', true);
define('NO_AGENT_CHECK', true);

if (isset($_REQUEST['site_id']) && is_string($_REQUEST['site_id'])) {
    $siteID = trim($_REQUEST['site_id']);
    if ($siteID !== '' && preg_match('/^[a-z0-9_]{2}$/i', $siteID) === 1) {
        define('SITE_ID', $siteID);
    }
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

use Bitrix\Main\Loader;

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->addFilter(new \Bitrix\Main\Web\PostDecodeFilter);

if (!check_bitrix_sessid() || !$request->isPost() || !Loader::includeModule('iblock')) {
    return;
}

$params = [];

$signer = new \Bitrix\Main\Security\Sign\Signer;
// Извлекаем параметры компонента
try {
    $params = $signer->unsign($request->getPost('signedParamsString'), 'ajax.form');
    $params = unserialize(base64_decode($params));
} catch (Exception $e) {
    die();
}

global $APPLICATION;

$APPLICATION->IncludeComponent(
    'khudyakov:ajax.form',
    '.default',
    $params,
    false,
    [
        'HIDE_ICONS' => 'Y',
    ]
);