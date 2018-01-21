<?php
define('InEmpireCMSCopyPath',TRUE);

//本程序由wm_chief原创，如要转载，请注明作者与来源(http://www.phome.net)
class copy_path{
	function wm_chief_copypath($o_path,$n_path)
	{
		$hand=@opendir($o_path);
		if(!file_exists($n_path))//目标目录不存在则建立
		{
			$this->wm_chief_createpath($n_path);
		}
		$i=0;
		while($file=@readdir($hand))
		{
			$i++;
			if($file!="."&&$file!="..")
			{
				//目录
				if(is_dir($o_path."/".$file))
				{
					$o_s_path=$o_path."/".$file;
					$n_s_path=$n_path."/".$file;
					$this->wm_chief_copypath($o_s_path,$n_s_path);
				}
				else
				{
					$o_file=$o_path."/".$file;
					$n_file=$n_path."/".$file;
					$this->wm_chief_copyfile($o_file,$n_file);
				}
			}
		}
		@closedir($hand);
		return true;
	}
	function wm_chief_copyfile($o_file,$n_file)
	{
		@copy($o_file,$n_file);
	}
	function wm_chief_createpath($n_path)
	{
		@mkdir($n_path,0777);
		@chmod($n_path,0777);
	}
}
//本程序由wm_chief原创，如要转载，请注明作者与来源(http://www.phome.net)
?>