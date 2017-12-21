<?php
$LANG['all_import'] 					=	'全部';
$LANG['content_import'] 				=	'信息导入';
$LANG['member_import'] 					=	'会员导入';
$LANG['other_import'] 					=	'其它';

$LANG['import_name'] 					=	'配置名称';
$LANG['import_desc'] 					=	'配置说明';
$LANG['add_time'] 						=	'添加时间';
$LANG['import_time'] 					=	'导入时间';
$LANG['import_type'] 					=	'导入类型';

$LANG['do_import'] 						=	'执行';

$LANG['delete_select'] 					=	'删除选中';
$LANG['delete_confirm'] 				=	'是否确定删除该记录？';
/*共用*/
$LANG['dbtype'] 						=	'数据库类型';
$LANG['dbhost'] 						=	'数据库主机';
$LANG['dbusername'] 					=	'数据库用户名';
$LANG['dbpassword'] 					=	'数据库密码';
$LANG['dbcharset'] 						=	'数据库编码';
$LANG['dbname'] 						=	'数据库名称';
$LANG['dbtables'] 						=	'选择数据库表';
$LANG['test_con'] 						=	'测试链接';

$LANG['show_tables'] 					=	'显示数据表';

$LANG['show_tables_fields'] 			=	'显示已选数据表字段';

$LANG['condition'] 						=	'数据提取条件';
$LANG['keyid'] 							=	'主键字段指定';
$LANG['maxid'] 							=	'上次导入最大ID';

$LANG['condition_info'] 				=	'（常用于多表联合查询时设置，例：v9_news.id=v9_news_data.id）';


$LANG['select_localhost_db'] 			=	'请选择本机数据库';
$LANG['pdo_select'] 					=	'选择数据表';
$LANG['into_tables'] 					=	'已经选择数据表';

$LANG['field_dy'] 						=	'数据表字段对应关系';
$LANG['field_name'] 					=	'字段名';
$LANG['field_pdo_name'] 				=	'对应源数据表字段';
$LANG['field_values'] 					=	'默认值';
$LANG['field_func'] 				     	=	'处理函数';
/*导入配置*/
$LANG['import_setting'] 				=	'数据导入执行设置';
$LANG['number'] 						=	'每次提取并导入数据条数';
$LANG['expire'] 						=	'php脚本执行超时时限'; 

/*其它*/
$LANG['import_type_other'] 				=	'数据导入规则- 通用导入';

/*信息导入*/
$LANG['import_type_content'] 			=	'数据导入规则- 内容导入';
$LANG['defaultcatid'] 					=	'默认导入栏目';
$LANG['v9_catid'] 						=	'现运行系统栏目';
$LANG['old_catid'] 						=	'原系统栏目ID';


/*会员导入*/
$LANG['import_type_member'] 			=	'数据导入规则- 会员导入';
$LANG['import_lanmu_dy'] 				=	'栏目对应设置';
$LANG['defaultgroupid'] 				=	'默认导入到用户组';
$LANG['v9_group'] 						=	'V9 会员组';
$LANG['old_group'] 						=	'原系统会员组 ID';
$LANG['membercheck'] 					=	'是否检查同名帐号或邮件';
$LANG['keyid_info'] 					=	'（用于多表联合查询时设置，例：ID）';

/*添加检测语言包*/
$LANG['importname_must'] 				=	'配置名称必填';
$LANG['input_importname'] 				=	'请输入配置名称';
$LANG['name_is_exit'] 					=	'已有同名配置。';
$LANG['connecting'] 					=	'正在连接，请稍候。';
$LANG['dbhost_infos'] 					=	'请输入数据库主机，当连接为Access时此处应填写数据库绝对地址';
$LANG['please_check_dbhost'] 			=	'请输入数据库主机';
$LANG['input_isok'] 					=	'输入正确';

/*扩展语言包*/
$LANG['access_input_table'] 			=	'(当选择数据类型为access时，请直接输入表名)';
$LANG['maxid_info'] 					=	'（防止数据重复导入，需配合 <font color=red>数据提取条件</font> 选项使用）';
$LANG['please_select'] 					=	'请选择';

$LANG['please_select_pdo'] 				=	'请选择数据源';

$LANG['old_catid_info'] 				=	'多个ID请用逗号分隔'; 

$LANG['tiao'] 							=	'条';
$LANG['miao'] 							=	'秒'; 

$LANG['connect_succeed'] 				=	'链接成功';
$LANG['connect_fail'] 					=	'链接失败'; 

/*后台模版语言包*/
$LANG['change_import_set'] 				=	'修改数据导入规则';
$LANG['select_model'] 					=	'选择要导入的模型：'; 
$LANG['other_model'] 					=	'其它 (<font color=red>没有限制,可任意指定数据表</font>)'; 

$LANG['all_type'] 						=	'所有分类'; 
$LANG['check_model'] 					=	'对应模型'; 

$LANG['add_import_setting'] 			=	'添加数据导入规则'; 
$LANG['no_confie'] 						=	'没有限制,可任意指定数据表'; 

$LANG['no_data_needimport'] 			=	'没有新数据需要导入，请返回！'; 
$LANG['no_keyid'] 						=	'没有指定关键字段，请返回！'; 
$LANG['no_default_groupid'] 			=	'没有指定默认会员组'; 
$LANG['no_default_catid'] 				=	'没有默认栏目配置'; 
?>