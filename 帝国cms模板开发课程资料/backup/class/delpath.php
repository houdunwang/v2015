<?
//删除目录
//本程序由wm_chief原创，如要转载，请注明作者与来源(http://www.phome.net)
class  del_path
{
function  wm_chief_delpath($del_path)
{
if(!file_exists($del_path))//目标目录不存在则建立
{echo"Directory not found.";return  false;}
$hand=@opendir($del_path);
$i=0;
while($file=@readdir($hand))
{$i++;
if ($file!="."&&$file!="..")
	{
   //目录
if(is_dir($del_path."/".$file))
{
$del_s_path=$del_path."/".$file;
$this->wm_chief_delpath($del_s_path);
}
else
{
$del_file=$del_path."/".$file;
$this->wm_chief_file($del_file);
}
	}
}
@closedir($hand);
$this->wm_chief_path($del_path);
return  true;
}
//删除文件
function  wm_chief_file($del_file)
{
@unlink($del_file);
}
//删除目录
function  wm_chief_path($del_path)
{
@rmdir($del_path);
}
}
//本程序由wm_chief原创，如要转载，请注明作者与来源(http://www.phome.net)
?>