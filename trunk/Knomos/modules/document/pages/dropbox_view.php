<?
include("../../../framework/framework.php");
include("../functions.php");
//include 'Dropbox/autoload.php';
// Define page specific text for template
$PAGE[TXT_TITLE]=DOCUMENT_MENU_0;
$PAGE[PAGE_INTITLE]=DOCUMENT_DROPBOX;
$PAGE[PAGE_PICTITLE]="dropbox_logo_home.png";
$module="document";

if ($_SESSION[mobile]==true){
	template_init(6); //mobile=6 - normale=2
} 
 else {
	template_init(); //mobile=6 - normale=2
}
	
//template_init(); //mobile=6 - desktop =()
ob_start();



if ($_GET[action]=="del" )
{

	$rs=$DB->Execute("SELECT * FROM document where id=".$_GET[id]);
	$thisfile=$rs->FetchRow();
	
	if (check_perm_obj("pratiche",$thisfile[ref_prat],"d"))
	{
		if($DB->Execute("DELETE FROM $module WHERE id=".$_GET[id]))
		{
			$PAGE_ELEMENT[PAGE][1][0][param]=$thisfile[ref_prat];
			$filename=$thisfile[filename].'-'.$thisfile[id].'-'.$thisfile[version].'.'.$thisfile[ext];
			if (file_exists($CONF[path_base].$CONF[dir_upload].'document/'.$filename))
			{
				unlink ($CONF[path_base].$CONF[dir_upload].'document/'.$filename);
				if ($thisfile[version] > 1) {
					if ($thisfile[ref_id] == 0) {
						$rs_old=$DB->Execute("SELECT * FROM document WHERE ref_id=".$thisfile[id]." order by version desc");
						if ($rs_old->RecordCount() > 0)
						{
							$older=$rs_old->FetchRow();
							$rs_upd1=$DB->Execute("UPDATE document set ref_id=0 WHERE id=".$older[id]);
							$rs_upd1=$DB->Execute("UPDATE document set ref_id=".$older[id]." WHERE ref_id=".$thisfile[id]);
						}
						
					}
				}
			}
			$res_del[title]=FW_DEL_OK;
			print draw_response($res_del);
		} else {
			$res_del[title]=FW_DEL_KO;
			print draw_response($res_del);
		}
			
		
	} else {
		$res_del[title]=FW_ERROR_NO_PERM_DEL;
		print draw_response($res_del);
	}	
	
}


if (check_perm_mod($module,"r")==1)
{

	$thissearch= load_fwobject("search","document",0);
	
	//Check for parent Perm
	$perm_parent = perm_sql_read("%[PERM]%","pratiche");
	$perm_parent = str_replace ("permessi","p.permessi",$perm_parent);
	$perm_parent = str_replace ("id","p.id",$perm_parent);
	$true_sql="SELECT m.* FROM document m, pratiche p WHERE $perm_parent AND p.id=m.ref_id ";
	
	
	if ($_GET[form_id]==$thissearch[form][name] ){
		$error=check_form($thissearch[form],$_GET,$page);
		if($error==1) {	
			//Dati della pratica 
			$qP="SELECT * FROM pratiche WHERE Id = ".$_GET[ref_prat][realval][0];
			$rsP=$DB->Execute($qP);
			$ThisPrat=$rsP->FetchRow();
			//$p=$ThisPrat[pr_ref_idcliente];
			//Dati del contatto
			//$qC="SELECT * FROM contact WHERE Id = ".$p;
			//$rsC=$DB->Execute($qC);
			//$ThisCont=$rsC->FetchRow();
			//$c1=$ThisCont[nome];
			//$c = str_replace(' ', '%20', $c1);
			//if ($c1=="Difese ufficio") {$In="";}
			//else {$In=substr($c,0,1)."/";}//Cartella con l'iniziale del nome
			//URL
			//$St1=$CONF[dbox_url]; // Definita in Config.php
			//$St2=$In.$c;
			//$url=$St1.$St2;
			//$StTx=$In.$c1;
			//$St1a=trim($St1);
			//FINE
			$sched=$ThisPrat[pr_schedario];
			$schedario= str_replace(' ', '%20', $sched);

			if ($_SESSION[mobile]==true){
				$St1=$CONF[dbox_m_url].$CONF[dbox_schedario]; // Definita in Config.php
			} 
			 else {
				$St1=$CONF[dbox_url].$CONF[dbox_schedario]; // Definita in Config.php
			}

			$url=$St1.$schedario;
			$St1a=trim($St1);
			$StTx=$sched;
			if (count($_GET[ref_prat][realval]) ==1 && strlen($_GET[ref_prat][realval]) > 0) {
				$PAGE_ELEMENT[PAGE][1][0][param]=$_GET[ref_prat][realval][0];
				$PAGE[PAGE_INTITLE].= " &nbsp;&nbsp;<span >Percorso: <input  id='TxPerc' name='TxPercorso' size='39' maxlength='39'  value='$CONF[dbox_schedario]$StTx'>
			( <a target=\"\" href=\"#\" onclick=\"javascript:NewRicDropBox('$St1a')\">".DOCUMENT_NEW_DROPBOX."</a> )
</span>";
					;
			}

		
			//INIZIO PAGINA

			print '
			<iframe  " VSPACE="0" name="Frame1" id="Fr1"  src='.$url.'  width="100%" height="399px" frameborder=0  MARGINWIDTH="0" marginheight="0"> </iframe> 
      				
			';//FINE PAGINA

			if (strlen($_GET[testo]) > 4)
			{
				$resfile=searchDocuments($_GET[testo]);
				if (count($resfile)==0)
				{$_GET[testo]="";} else $_GET[testo]=$resfile;
			} else $_GET[testo]="";
			
		} else print draw_form($thissearch[form],$module,$error,$_GET);
		
		} else 
		{print draw_form($thissearch[form],$module,"",$_GET);
		 //print menage_search($thissearch[search]);
		}
} else {
	$response[title]=FW_ERROR_NO_PERM;
	$response[text]=FW_ERROR_NO_PERM_TXT;
	$iserror=1;
	print draw_response($response);
}


$PAGE[PAGE_CONTENT] = ob_get_contents();
ob_end_clean();
template_define_elements();

final_render();

?>
