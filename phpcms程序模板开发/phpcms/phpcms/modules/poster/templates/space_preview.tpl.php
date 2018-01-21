<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo L('preview')?></title>
</head>
<body>
<table width="100%" border="0" cellspacing="0" align="center" >

<tr align="center" valign="middle">
	<td align="center" valign="middle"><?php if($r['type']=='code') { echo $data; } else {?><script language='javascript' src='<?php echo $path;?>'></script><?php }?></td>
</tr>
</table>
</body>
</html>