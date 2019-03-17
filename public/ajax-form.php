<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("AJAX форма");
?>
 <?$APPLICATION->IncludeComponent(
	"khudyakov:ajax.form", 
	".default", 
	array(
		"IBLOCK_ID" => "1",
		"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "-",
		"SUCCESS_MESSAGE" => "Форма сохранена",
		"ERROR_MESSAGE" => "",
		"FORM_TITLE" => "AJAX форма"
	),
	false
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>