<?php
//帝国网站管理系统FTP

define('InEmpireCMSFtp',TRUE);

class EmpireCMSFTP{
	var $ftpconnectid;
	var $ftptranmode;

	function wipespecial($str){   
		return str_replace(array("\n","\r"),array('',''),$str);   
	}

	//链接
	function fconnect($ftphost,$ftpport,$ftpusername,$ftppassword,$ftppath,$ftpssl=0,$pasv=0,$tranmode=0,$timeout=0,$checkftp=0){
		$ftphost=$this->wipespecial($ftphost);
		$func=$ftpssl&&function_exists('ftp_ssl_connect')?'ftp_ssl_connect':'ftp_connect';
		$this->ftpconnectid=@$func($ftphost,$ftpport,20);
		if(!$this->ftpconnectid)
		{
			if($checkftp==1)
			{
				return 'HostFail';
			}
			echo"Fail to connect ftp host!";
			exit();
		}
		if($timeout&&function_exists('ftp_set_option'))
		{
			@ftp_set_option($this->ftpconnectid,FTP_TIMEOUT_SEC,$timeout);
		}
		$login=$this->fLogin($ftpusername,$ftppassword);
		if(!$login)
		{
			if($checkftp==1)
			{
				$this->fExit();
				return 'UserFail';
			}
			echo"The username/password for ftp is error!";
			$this->fExit();
			exit();
	    }
		if($pasv)
		{
			$this->fPasv(TRUE);
		}
		$ftppath=empty($ftppath)?'/':$ftppath;
		$chdir=$this->fChdir($ftppath);
		if(!$chdir)
		{
			if($checkftp==1)
			{
				$this->fExit();
				return 'PathFail';
			}
			echo"The path for ftp is error!";
			$this->fExit();
			exit();
		}
		$this->ftptranmode=$tranmode?FTP_ASCII:FTP_BINARY;
	}

	//登录
	function fLogin($username,$password) {
		$username=$this->wipespecial($username);
		$password=$this->wipespecial($password);
		return @ftp_login($this->ftpconnectid,$username,$password);
	}

	//关闭ftp
	function fExit(){
		return @ftp_quit($this->ftpconnectid);
    }

	//链接模式
	function fPasv($pasv){
		return @ftp_pasv($this->ftpconnectid,$pasv);
	}

	//改变路径
	function fChdir($path){
		$path=$this->wipespecial($path);
		return @ftp_chdir($this->ftpconnectid,$path);
	}
	
	//建立目录
	function fMkdir($path){
		$path=$this->wipespecial($path);
		@ftp_mkdir($this->ftpconnectid,$path);
    }

	//向服务器发送 SITE 命令
	function fSiteCmd($cmd){
		$cmd=$this->wipespecial($cmd);
		return @ftp_site($this->ftpconnectid,$cmd);
	}

	//设置目录权限
	function fChmoddir($mode,$filename){
		$mode=intval($mode);
		$filename=$this->wipespecial($filename);
		if(function_exists('ftp_chmod'))
		{
			return @ftp_chmod($this->ftpconnectid,$mode,$filename);
		}
		else
		{
			return $this->fSiteCmd('CHMOD '.$mode.' '.$filename);
		}
	}

	//删除目录
	function fRmdir($path){
		$path=$this->wipespecial($path);
		return @ftp_rmdir($this->ftpconnectid,$path);
	}

	//上传文件
	function fTranFile($hfile,$lfile,$startpos=0,$del=0){
		$hfile=$this->wipespecial($hfile);
		$lfile=$this->wipespecial($lfile);
		$startpos=intval($startpos);
		$tran=@ftp_put($this->ftpconnectid,$hfile,$lfile,$this->ftptranmode,$startpos);
		if($del)
		{
			DelFiletext($lfile);
		}
		return $tran;
    }

	//上传单文件(含建目录)
	function fTranPathFile($basepath,$path,$hfile,$lfile,$del=0){
		//建目录
		$this->ftp_mkdirs($basepath,$path);
		//上传文件
		$this->fTranFile($hfile,$lfile,0,$del);
	}

	//上传多文件
	function fMoreTranFile($hfile,$lfile,$del=0){
		$count=count($hfile);
		for($i=0;$i<$count;$i++)
		{
			$this->fTranFile($hfile[$i],$lfile[$i],0,$del);
		}
    }

	//上传多文件(含建目录)
	function fMoreTranPathFile($basepath,$path,$hfile,$lfile,$del=0){
		//建目录
		$this->ftp_mkdirs($basepath,$path);
		//上传文件
		$this->fMoreTranFile($hfile,$lfile,$del);
	}

	//下载文件
	function fGetFile($lfile,$hfile,$resumepos=0){
		$hfile=$this->wipespecial($hfile);
		$lfile=$this->wipespecial($lfile);
		$resumepos=intval($resumepos);
		return @ftp_get($this->ftpconnectid,$lfile,$hfile,$this->ftptranmode,$resumepos);
	}

	//文件大小
	function fSize($hfile){
		$hfile=$this->wipespecial($hfile);
		return @ftp_size($this->ftpconnectid,$hfile);
	}

	//删除文件
	function fDelFile($hfile){
		$hfile=$this->wipespecial($hfile);
		return @ftp_delete($this->ftpconnectid,$hfile);
    }

	//删除多文件
	function fMoreDelFile($hfile){
		$count=count($hfile);
		for($i=0;$i<$count;$i++)
		{
			$this->fDelFile($hfile[$i]);
		}
    }

	//重命名文件
	function fRename($oldfile,$newfile){
		$oldfile=$this->wipespecial($oldfile);
		$newfile=$this->wipespecial($newfile);
		return @ftp_rename($this->ftpconnectid,$oldfile,$newfile);
	}

	//获得当前路径
	function fPwd(){
		return @ftp_pwd($this->ftpconnectid);
	}

	//上传目录
	function ftp_copy($src_dir,$dst_dir){
		$src_dir=$this->wipespecial($src_dir);
		$dst_dir=$this->wipespecial($dst_dir);
		if(!$this->fChdir($dst_dir))
		{
			$this->fMkdir($dst_dir);
        }
		$d=@opendir($src_dir);
		while($file=@readdir($d))
		{
			if($file!= "."&&$file!="..")
			{
				if(is_dir($src_dir."/".$file))
				{
					$this->ftp_copy($src_dir."/".$file,$dst_dir."/".$file);
				}
				else 
				{
					$this->fTranFile($dst_dir."/".$file,$src_dir."/".$file);
				}
			}
		}
		@closedir($d);
	}

	//返回目录的文件列表
	function fNlist($path) {
		$path=$this->wipespecial($path);
		return @ftp_nlist($this->ftpconnectid,$path);
	}

	//删除目录
	function ftp_rmAll($path,$flag=true){
		$path=$this->wipespecial($path);
		if($flag)
		{
			$ret=$this->fRmdir($path)||$this->fDelFile($path);
		}
		else
		{
			$ret=false;
		}
		if(!$ret)
		{
			$files=$this->fNlist($path);
			foreach($files as $values)
			{
				$values=basename($values);
				$dirfile=$path.'/'.$values;
				if($this->fSize($dirfile)==-1)
				{
					$this->fDelFile($dirfile);
				}
				else
				{
					$this->ftp_rmAll($dirfile,true);
				}
			}
			if($flag)
			{
				return $this->fRmdir($path);
			}
			else
			{
				return true;
			}
		}
		else
		{
			return $ret;
		}
	}

	//建多目录
	function ftp_mkdirs($basepath,$path){
		$basepath=$this->wipespecial($basepath);
		$path=$this->wipespecial($path);
		if(empty($path))
		{
			return '';
		}
		$r=explode('/',$path);
		$count=count($r);
		for($i=0;$i<$count;$i++)
		{
			if($i>0)
			{
				$returnpath.='/'.$r[$i];
			}
			else
			{
				$returnpath.=$r[$i];
			}
			$createpath=$basepath.$returnpath;
			if(!$this->fChdir($createpath))
			{
				$mk=$this->fMkdir($createpath);
				if(empty($mk))
				{
					printerror("CreatePathFail","");
				}
			}
		}
	}
}
?>