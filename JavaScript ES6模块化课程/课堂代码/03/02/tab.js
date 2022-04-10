function tab(menu,con){
	
//	给导航块加单击事件
	menu.click(function(){
//		获得序号
		var c = $(this).index();
//		让c号内容块显示,兄弟块隐藏
		con.hide();
		con.eq(c).show();
	})
	
	
}


export {tab};
