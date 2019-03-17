<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("KOT_IBLOCK_DESC_LIST"),
	"DESCRIPTION" => GetMessage("KOT_IBLOCK_DESC_LIST_DESC"),
//	"ICON" => "/images/news_list.gif",
	"SORT" => 20,
//	"SCREENSHOT" => array(
//		"/images/post-77-1108567822.jpg",
//		"/images/post-1169930140.jpg",
//	),
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "khudyakov",
		"CHILD" => array(
			"ID" => "test",
			"NAME" => GetMessage("KOT_IBLOCK_DESC_TEST"),
			"SORT" => 10,
			"CHILD" => array(
				"ID" => "test_form",
			),
		),
	),
);

?>