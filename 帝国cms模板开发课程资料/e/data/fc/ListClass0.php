<?php
if(!defined('InEmpireCMS'))
{
	exit();
}
?><tr bgcolor='#ffffff' height=25><td><input type=text name=myorder[] value=0 size=2><input type=hidden name=classid[] value=3></td><td><a href='#e' onclick=addi(3)><img src='../data/images/txt.gif' border=0></a></td><td align=center>3</td><td><input type=checkbox name=reclassid[] value=3> <a href='/e/action/ListInfo/?classid=3' target=_blank>轮播图</a></td><td align=center>0</td><td><a href='#e' onclick=editc(3)>修改</a> <a href='#e' onclick=copyc(3)>复制</a> <a href='#e' onclick=delc(3)>删除</a></td><td><a href='#e' onclick=relist(3)>刷新</a> <a href='#e' onclick=renews(3,'slide')>信息</a> <a href='#e' onclick=rejs(3)>JS</a> <a href='#e' onclick=tvurl(3)>调用</a> <a href='#e' onclick=ttc(3)>分类</a> <a href='#e' onclick=docinfo(3)>归档</a></td></tr>