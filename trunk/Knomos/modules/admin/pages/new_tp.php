<?
include("../../../framework/framework.php");

// Define page specific text for template
$PAGE[PAGE_PICTITLE]="ico_admin_med.gif";
$module="admin";



template_init();
template_define_elements();

ob_start();

$thisform= load_fwobject("form",$module,2);



if (isset($_GET[id]) && $_POST[form_id]!= $thisform["name"])
{
	
	$PAGE[PAGE_INTITLE]=ADMIN_TP_UPD;
	$PAGE[TXT_TITLE]=ADMIN_TP_UPD;
	$rs=$DB->Execute("SELECT * FROM INT_pratiche_tipo WHERE id=".$_GET[id]);
	$result=$rs->FetchRow();
	
	$thisform[onpost]=str_replace("type::add","type::upd",$thisform[onpost]);
	$thisform[Fields][send][content]="submit||".ADMIN_TP_UPD."||";
	$response[title]=ADMIN_TP_UPD_DONE;
	$response[text]= ADMIN_TP_UPD_DONE_TXT."<br><br>".make_button("tp_view.php",ADMIN_TP_BACK_LIST);

} elseif (isset($_GET[id]))
{ 
	$result=$_POST;
	$PAGE[PAGE_INTITLE]=ADMIN_TP_UPD;
	$PAGE[TXT_TITLE]=ADMIN_TP_UPD;
	$response[title]=ADMIN_TP_UPD_DONE;
	$response[text]= ADMIN_TP_UPD_DONE_TXT."<br><br>".make_button("tp_view.php",ADMIN_TP_BACK_LIST);
	$thisform[onpost]=str_replace("type::add","type::upd",$thisform[onpost]);
	$thisform[Fields][send][content]="submit||".ADMIN_TP_UPD."||";

} else {
	$PAGE[PAGE_INTITLE]=ADMIN_TP_ADD;
	$PAGE[TXT_TITLE]=ADMIN_TP_ADD;
	$response[title]=ADMIN_TP_ADD_DONE;
	$response[text]= ADMIN_TP_ADD_DONE_TXT."<br><br>".make_button("tp_view.php",ADMIN_TP_BACK_LIST);
}




if ($_POST[form_id]==$thisform["name"])
{	if(isset($_POST[form_page])) {$page=$_POST[form_page];}
	else $page=1;
	$error=check_form($thisform,$_POST,$page);
	if($error==1) {
		$manage=manage_post($thisform,$error,$_POST,$_GET[id]);
	} else print draw_form($thisform,$module,$error,$_POST,$page);
	if ($manage==1) {
		$page=($_POST[form_page]+1);
		print draw_form($thisform,$module,$error,$_POST,$page);
	}
	elseif ($manage > 1)
	{
		print draw_response($response);
	}
	
} else {
	print draw_form($thisform,$module,"",$result);
}



$PAGE[PAGE_CONTENT] = ob_get_contents();
ob_end_clean();

final_render();

?>