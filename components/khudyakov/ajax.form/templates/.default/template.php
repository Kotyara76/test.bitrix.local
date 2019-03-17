<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
// todo вынести labels в языковые файлы
CJSCore::Init(['jquery', 'ajax']);
?>
<div class="ajax-form-component">
    <div id="<?=$arParams['FORM_ID']?>-error-wrapper" class="error-wrapper <?=(strlen($arResult['error'])) ?: 'hidden'?>">
        <?=$arResult['error']?>
    </div>
    <div id="<?=$arParams['FORM_ID']?>-success-wrapper" class="success-wrapper <?=(strlen($arResult['success'])) ?: 'hidden'?>">
        <?=$arResult['success']?>
    </div>
    <div id="<?=$arParams['FORM_ID']?>-form-wrapper" class="form-wrapper">
        <form action="<?=POST_FORM_ACTION_URI?>" id="<?=$arParams['FORM_ID']?>">
            <?=bitrix_sessid_post()?>
            <div>
                <label for="<?=$arParams['FORM_ID']?>-name">Название:</label><br>
                <input id="<?=$arParams['FORM_ID']?>-name" type="text" name="name" value="<?=$arResult['values']['name']?>"/>
            </div>
            <div>
                <label for="<?=$arParams['FORM_ID']?>-description">Описание:</label><br>
                <textarea id="<?=$arParams['FORM_ID']?>-description" name="description" cols="30" rows="10"><?=$arResult['values']['description']?></textarea>
            </div>
            <button type="submit" name="ajax-form-submit">Сохранить</button>
        </form>
    </div>
    <?
    // Подписываем и отдаём в JS параметры компонента
    $signer = new \Bitrix\Main\Security\Sign\Signer;
    $signedParams = $signer->sign(base64_encode(serialize($arParams)), 'ajax.form');
    ?>
    <script>
        BX.ready(function () {
            AjaxForm_<?=CUtil::JSEscape($arParams['FORM_ID'])?> = new AjaxFormComponent({
                signedParamsString: '<?=CUtil::JSEscape($signedParams)?>',
                siteId: '<?=CUtil::JSEscape($component->getSiteId())?>',
                ajaxUrl: '<?=CUtil::JSEscape($component->getPath().'/ajax.php')?>',
                formId: '<?=CUtil::JSEscape($arParams['FORM_ID'])?>'
            });
        });
    </script>
</div>
