// JavaScript Document
function chengstate(menuid,save)
{											//切换节点的开放/关闭
	menuobj	= eval("item"+menuid);
	obj		= eval("pr"+menuid);
	
	if(menuobj.style.display == '')
	{
		menuobj.style.display	= 'none';
	}else{
		menuobj.style.display	= '';
	}//end if
	switch (obj.className)
	{
		case "menu1":
			obj.className	= "menu2";
			break;
		case "menu2":
			obj.className	= "menu1";
			break;
		case "menu3":
			obj.className	= "menu4";
			break;
		case "menu4":
			obj.className	= "menu3";
			break;
	}//end switch
	if(save!=false)
	{
		setupcookie(menuid);			//保存状态
	}//end if
}//end funciton chengstaut

function setupcookie(menuid)
{										//存入cookie  保存节点状态
	var menu	= new Array();
	var menustr	= new String();
	menuOpen	= false;
	if(checkCookieExist("menu"))
	{									//判断是否是是否已经保存过cookie
		menustr		= getCookie("menu");
		//alert(menustr);
		if(menustr.length>0)
		{								//判断menu是否为空，，，否则分解为数组
			menu	= menustr.split(",");
			for(i=0;i<menu.length;i++)
			{
				if(menu[i]==menuid)
				{						//如果是打开状态，，，删除记录
					menu[i]='';
					menuOpen	= true;
				}//end if
			}//end for
			if(menuOpen==false)menu[i] = menuid;
		}else{
			menu[0]	= menuid;
		}//end if
	}else{
		menu[0]	= menuid;
	}//end if
	menustr	= menu.join(",");
	menustr	= menustr.replace(",,",",");
	if(menustr.substr(menustr.length-1,1)==',')menustr = menustr.substr(0,menustr.length-1);		//去掉最后的 ","
	if(menustr.substr(0,1)==',')menustr = menustr.substr(1,menustr.length-1);		//去掉开始的 ","
	saveCookie("menu",menustr,1000);
	//alert(menustr);
	//deleteCookie("menu");
}//end function setupcookie

function initialize()
{											//取得cookie  设置节点的缩放,,初始化菜单状态
	var menu	= new Array();
	var menustr	= new String();
	
	if(checkCookieExist("menu"))
	{									//判断是否是是否已经保存过cookie
		menustr		= getCookie("menu");
		if(menustr.length>0)
		{								//判断长度是否合法
			menu	= menustr.split(",");
			for(i=0;i<menu.length;i++)
			{
				if(objExists(menu[i]))			
				{						//验证对象是否存在
					chengstate(menu[i],false);
				}//end if
			}//end for
			objExists(99);
		}//end if
	}//end if
}//end funciton setupstate

function objExists(objid)
{											//验证对象是否存在
	try
	{
		obj = eval("item"+objid);
	}//end try
	catch(obj)
	{
		return false;
	}//end catch
	
	if(typeof(obj)=="object")
	{
		return true;
	}//end if
	return false;
}//end function objExists
//--------------------------------------------------↓↓↓↓↓↓↓↓↓↓↓↓  执行Cookie 操作
function saveCookie(name, value, expires, path, domain, secure)
{											// 保存Cookie
  var strCookie = name + "=" + value;
  if (expires)
  {											// 计算Cookie的期限, 参数为天数
     var curTime = new Date();
     curTime.setTime(curTime.getTime() + expires*24*60*60*1000);
     strCookie += "; expires=" + curTime.toGMTString();
  }//end if
  // Cookie的路径
  strCookie +=  (path) ? "; path=" + path : ""; 
  // Cookie的Domain
  strCookie +=  (domain) ? "; domain=" + domain : "";
  // 是否需要保密传送,为一个布尔值
  strCookie +=  (secure) ? "; secure" : "";
  document.cookie = strCookie;
}//end funciton saveCookie

function getCookie(name)
{											// 使用名称参数取得Cookie值, null表示Cookie不存在
  var strCookies = document.cookie;
  var cookieName = name + "=";  // Cookie名称
  var valueBegin, valueEnd, value;
  // 寻找是否有此Cookie名称
  valueBegin = strCookies.indexOf(cookieName);
  if (valueBegin == -1) return null;  // 没有此Cookie
  // 取得值的结尾位置
  valueEnd = strCookies.indexOf(";", valueBegin);
  if (valueEnd == -1)
      valueEnd = strCookies.length;  // 最后一个Cookie
  // 取得Cookie值
  value = strCookies.substring(valueBegin+cookieName.length,valueEnd);
  return value;
}//end function getCookie

function checkCookieExist(name)
{											// 检查Cookie是否存在
  if (getCookie(name))
      return true;
  else
      return false;
}//end function checkCookieExist

function deleteCookie(name, path, domain)
{											// 删除Cookie
  var strCookie;
  // 检查Cookie是否存在
  if (checkCookieExist(name))
  {										    // 设置Cookie的期限为己过期
    strCookie = name + "="; 
    strCookie += (path) ? "; path=" + path : "";
    strCookie += (domain) ? "; domain=" + domain : "";
    strCookie += "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    document.cookie = strCookie;
  }//end if
}//end function deleteCookie