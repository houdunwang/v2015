function checkradio(radio)
{
	var result = false;
	for(var i=0; i<radio.length; i++)
	{
		if(radio[i].checked)
		{
			result = true;
			break;
		}
	}
    return result;
}

function checkselect(select)
{
	var result = false;
	for(var i=0;i<select.length;i++)
	{
		if(select[i].selected && select[i].value!='' && select[i].value!=0)
		{
			result = true;
			break;
		}
	}
    return result;
}
var set_show = false;
jQuery.fn.checkFormorder = function(m,func){
	mode = (m==1) ? 1 : 0;
	var form=jQuery(this);
	var elements = form.find('input[require],select[require],textarea[require]');
	elements.blur(function(index){
		return validator.check(jQuery(this));
	});

	form.submit(function(){
		var ok = true;
		var errIndex= new Array();
		var n=0;
		elements.each(function(i){
			if(validator.check(jQuery(this))==false){
				ok = false;
				errIndex[n++]=i;
			};
		});

		if(ok==false){
			elements.eq(errIndex[0]).focus().select();
			return false;
		}
		if(document.getElementById('video_uploader') && !upLoading)
		{
			uploadFile();
			return false;
		}
		if($('#f_filed_1') && set_show==false)
		{
			$("select[@id=catids] option").each(function()
			{
				$(this).attr('selected','selected');
			});
		}
		if($('#hava_checked').val()==0)
		{
			YP_checkform();
			return false;
		}
        func();
        return false;
	});
}