<?php
/**
* @version $Id: install3.php,v 1.6 2005/02/14 09:47:42 kochp Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* Modified By Massimo Chieruzzi @ Creative Web snc  
* More info http://www.knomos.org - http://www.creativeweb.it 
*/

/** Include common.php */
include_once("common.php");

$DBhostname = trim( mosGetParam( $_POST, 'DBhostname', '' ) );
$DBuserName = trim( mosGetParam( $_POST, 'DBuserName', '' ) );
$DBpassword = trim( mosGetParam( $_POST, 'DBpassword', '' ) );
$DBname  	= trim( mosGetParam( $_POST, 'DBname', '' ) );
$DBPrefix  	= trim( mosGetParam( $_POST, 'DBPrefix', '' ) );
$sitename  	= trim( mosGetParam( $_POST, 'sitename', '' ) );
$adminUser = trim( mosGetParam( $_POST, 'adminUser', '') );
$configArray['siteUrl'] = trim( mosGetParam( $_POST, 'siteUrl', '' ) );
$configArray['absolutePath'] = trim( mosGetParam( $_POST, 'absolutePath', '' ) );
if (get_magic_quotes_gpc()) {
	$configArray['absolutePath'] = stripslashes(stripslashes($configArray['absolutePath']));
	$sitename = stripslashes(stripslashes($sitename));
}


echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Knomos - Web Installer</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="../../images/favicon.ico" />
<link rel="stylesheet" href="install.css" type="text/css" />
<script type="text/javascript">
<!--
function check() {
	// form validation check
	var formValid = true;
	var f = document.form;
	if ( f.siteUrl.value == '' ) {
		alert('Please enter Site URL');
		f.siteUrl.focus();
		formValid = false;
	} else if ( f.absolutePath.value == '' ) {
		alert('Please enter the absolute path to your site');
		f.absolutePath.focus();
		formValid = false;
	} else if ( f.adminEmail.value == '' ) {
		alert('Please enter an email address to contact your administrator');
		f.adminEmail.focus();
		formValid = false;
	} else if ( f.adminPassword.value == '' ) {
		alert('Please enter a password for you administrator');
		f.adminPassword.focus();
		formValid = false;
	}

	return formValid;
}

//-->
</script>
</head>
<body onload="document.form.siteUrl.focus();">
<div id="wrapper">
    <div id="header">
      <div id="knomos"> <img src="header_install.png" class="logo" alt="Knomos Installation" />
          <div class="version">Knomos v .1.0</div>
          <div class="clear-chusmy">&nbsp;</div>
      </div>
    </div>
</div>
<div id="ctr" align="center">
	<form action="install4.php" method="post" name="form" id="form" onsubmit="return check();">
	<input type="hidden" name="DBhostname" value="<?php echo "$DBhostname"; ?>" />
	<input type="hidden" name="DBuserName" value="<?php echo "$DBuserName"; ?>" />
	<input type="hidden" name="DBpassword" value="<?php echo "$DBpassword"; ?>" />
	<input type="hidden" name="DBname" value="<?php echo "$DBname"; ?>" />
	<input type="hidden" name="DBPrefix" value="<?php echo "$DBPrefix"; ?>" />
	<input type="hidden" name="sitename" value="<?php echo "$sitename"; ?>" />
	<div class="install">
	    <div id="stepbar">
	        <div class="step-ok">pre-installation check</div>
	        <div class="step-ok">license</div>
	        <div class="step-ok">step 1</div>
	        <div class="step-ok">step 2</div>
	        <div class="step-on">step 3</div>
	        <div class="step-off">step 4</div>
	    </div>
	    <div id="right">
	        <div id="step">step 3</div>
	        <div class="far-right">
		        <input class="button" type="submit" name="next" value="Next >>"/>
	        </div>
	        <div class="clr"></div>
    		<h1>Confirm the site URL, path, admin e-mail and file/directory chmods</h1>
    		<div class="install-text">
    			  <p>If URL and Path looks correct then please do not change.
    	          If you are not sure then please contact your ISP or administrator. Usually
    	          the values displayed will work for your site.<br/>
    	          <br/>
    	          Enter your e-mail address, this will be the e-mail address of the site
    	          SuperAdministrator.<br />
    	          <br/>
				  The permission settings will be used while installing mambo itself, by
				  the mambo addon-installers and by the media manager. If you are unsure
				  what flags shall be set, leave the default settings at the moment.
				  You can still change these flags later in the site global configuration.</p>
    		</div>
    		<div class="install-form">
    			<div class="form-block">
    				<table class="content2">
    		        <tr>
    		            <td width="100">URL</td>
<?php
	$url = "";
	if ($configArray['siteUrl'])
		$url = $configArray['siteUrl'];
    else {
        $root = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
        $root = str_replace("installation/","",$root);
        $root = str_replace("/install3.php","",$root);
        $url = "http://".$root;
    }
?>    		            <td align="center"><input class="inputbox" type="text" name="siteUrl" value="<?php echo $url; ?>" size="50"/></td>
					</tr>
    		        <tr>
    		            <td>Path</td>
<?php
	$abspath = "";
	if ($configArray['absolutePath'])
    	$abspath = $configArray['absolutePath'];
	else {
	    $path = getcwd();
    	if (preg_match("/\/installation/i", "$path"))
        	$abspath = str_replace('/installation',"",$path);
    	else
        	$abspath = str_replace('\installation',"",$path);
	}
?>    		            <td align="center"><input class="inputbox" type="text" name="absolutePath" value="<?php echo $abspath; ?>" size="50"/></td>
					</tr>
					<tr>
    		            <td>Your E-mail</td>
    		            <td align="center"><input class="inputbox" type="text" name="adminEmail" value="<?php echo "$adminEmail"; ?>" size="50" /></td>
					</tr>
					<tr>
    		            <td>Admin password</td>
    		            <td align="center"><input class="inputbox" type="text" name="adminPassword" value="<?php echo mosMakePassword(8); ?>" size="50"/></td>
	                </tr>
	                <tr>
<?php
	$mode = 0;
	$flags = 0644;
	if ($filePerms!='') {
		$mode = 1;
		$flags = octdec($filePerms);
	} // if
?>
    		            <td colspan="2">
  							<fieldset><legend>File Permissions</legend>
								<table cellpadding="1" cellspacing="1" border="0">
                            		<tr>
										<td><input type="radio" id="filePermsMode0" name="filePermsMode" value="0" onclick="changeFilePermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="filePermsMode0">Dont CHMOD files (use server defaults)</label></td>
									</tr>
									<tr>
                                		<td><input type="radio" id="filePermsMode1" name="filePermsMode" value="1" onclick="changeFilePermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="filePermsMode1"> CHMOD files to:</label></td>
									</tr>
									<tr id="filePermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
										<td>&nbsp;</td>
										<td>
	                                        <table cellpadding="1" cellspacing="0" border="0">
	                                            <tr>
	                                                <td>User:</td>
	                                                <td><input type="checkbox" id="filePermsUserRead" name="filePermsUserRead" value="1"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="filePermsUserRead">read</label></td>
	                                                <td><input type="checkbox" id="filePermsUserWrite" name="filePermsUserWrite" value="1"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="filePermsUserWrite">write</label></td>
	                                                <td><input type="checkbox" id="filePermsUserExecute" name="filePermsUserExecute" value="1"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
	                                                <td width="100%"><label for="filePermsUserExecute">execute</label></td>
	                                            </tr>
	                                            <tr>
	                                                <td>Group:</td>
	                                                <td><input type="checkbox" id="filePermsGroupRead" name="filePermsGroupRead" value="1"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="filePermsGroupRead">read</label></td>
	                                                <td><input type="checkbox" id="filePermsGroupWrite" name="filePermsGroupWrite" value="1"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="filePermsGroupWrite">write</label></td>
	                                                <td><input type="checkbox" id="filePermsGroupExecute" name="filePermsGroupExecute" value="1"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
	                                                <td width="100%"><label for="filePermsGroupExecute">execute</label></td>
	                                            </tr>
	                                            <tr>
	                                                <td>World:</td>
	                                                <td><input type="checkbox" id="filePermsWorldRead" name="filePermsWorldRead" value="1"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="filePermsWorldRead">read</label></td>
	                                                <td><input type="checkbox" id="filePermsWorldWrite" name="filePermsWorldWrite" value="1"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="filePermsWorldWrite">write</label></td>
	                                                <td><input type="checkbox" id="filePermsWorldExecute" name="filePermsWorldExecute" value="1"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
	                                                <td width="100%"><label for="filePermsWorldExecute">execute</label></td>
	                                            </tr>
	                                        </table>
										</td>
									</tr>
								</table>
							</fieldset>
                        </td>
	                </tr>
	                <tr>
<?php
	$mode = 0;
	$flags = 0755;
	if ($dirPerms!='') {
		$mode = 1;
		$flags = octdec($dirPerms);
	} // if
?>
    		            <td colspan="2">
  							<fieldset><legend>Directory Permissions</legend>
								<table cellpadding="1" cellspacing="1" border="0">
                            		<tr>
										<td><input type="radio" id="dirPermsMode0" name="dirPermsMode" value="0" onclick="changeDirPermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="dirPermsMode0">Dont CHMOD directories (use server defaults)</label></td>
									</tr>
									<tr>
                                		<td><input type="radio" id="dirPermsMode1" name="dirPermsMode" value="1" onclick="changeDirPermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
										<td><label for="dirPermsMode1"> CHMOD directories to:</label></td>
									</tr>
									<tr id="dirPermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
										<td>&nbsp;</td>
										<td>
	                                        <table cellpadding="1" cellspacing="0" border="0">
	                                            <tr>
	                                                <td>User:</td>
	                                                <td><input type="checkbox" id="dirPermsUserRead" name="dirPermsUserRead" value="1"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="dirPermsUserRead">read</label></td>
	                                                <td><input type="checkbox" id="dirPermsUserWrite" name="dirPermsUserWrite" value="1"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="dirPermsUserWrite">write</label></td>
	                                                <td><input type="checkbox" id="dirPermsUserSearch" name="dirPermsUserSearch" value="1"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
	                                                <td width="100%"><label for="dirPermsUserSearch">search</label></td>
	                                            </tr>
	                                            <tr>
	                                                <td>Group:</td>
	                                                <td><input type="checkbox" id="dirPermsGroupRead" name="dirPermsGroupRead" value="1"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="dirPermsGroupRead">read</label></td>
	                                                <td><input type="checkbox" id="dirPermsGroupWrite" name="dirPermsGroupWrite" value="1"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="dirPermsGroupWrite">write</label></td>
	                                                <td><input type="checkbox" id="dirPermsGroupSearch" name="dirPermsGroupSearch" value="1"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
	                                                <td width="100%"><label for="dirPermsGroupSearch">search</label></td>
	                                            </tr>
	                                            <tr>
	                                                <td>World:</td>
	                                                <td><input type="checkbox" id="dirPermsWorldRead" name="dirPermsWorldRead" value="1"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="dirPermsWorldRead">read</label></td>
	                                                <td><input type="checkbox" id="dirPermsWorldWrite" name="dirPermsWorldWrite" value="1"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
	                                                <td><label for="dirPermsWorldWrite">write</label></td>
	                                                <td><input type="checkbox" id="dirPermsWorldSearch" name="dirPermsWorldSearch" value="1"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
	                                                <td width="100%"><label for="dirPermsWorldSearch">search</label></td>
	                                            </tr>
	                                        </table>
										</td>
									</tr>
								</table>
							</fieldset>
                        </td>
	                </tr>
    				</table>
    			</div>
    		</div>
    		<div id="break"></div>
		</div>
		<div class="clr"></div>
	</div>
	</form>
</div>
<div class="clr"></div>
<div class="ctr">
<a href="http://www.knomos.org" target="_blank">Knomos</a> Web Installer based on <a href="http://www.mamboserver.com" target="_blank">Mambo</a>'s web installer. Mambo And Knomos are Free Software released under the GNU/GPL License.
</div>

</body>
</html>