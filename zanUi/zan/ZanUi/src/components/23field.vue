<template>
	<div class="field">
		<!--placeholder  提示性的语句-->
		<!--基础用法-->
		<!--<van-cell-group>
		  <van-field v-model="value" placeholder="请输入用户名" />
		</van-cell-group>-->
		
		<!--自定义类型-->
		<!--type  指定input表单的类型、-->
		<!--@click-icon  给右侧的小图标添加单击事件-->
		<!--icon  右侧的图标-->
		<!--<van-cell-group>
		  <van-field
		    v-model="username"
		    label="用户名"
		    icon="clear"
		    placeholder="请输入用户名"
		    required
		    @click-icon="username = ''"
		  />
		
		  <van-field
		    v-model="password"
		    type="password"
		    label="密码"
		    placeholder="请输入密码"
		    required
		  />
		</van-cell-group>-->
		
		
		<!--禁用输入框-->
		<!--disabled  禁用-->
			<!--<van-cell-group>
			  <van-field
			    value="输入框已禁用"
			    label="用户名"
			    disabled
			  />
			</van-cell-group>-->
			
			
			<!--错误提示-->
			<!--error-message="手机号格式错误"  提示错误的文字-->
			<!--error  让字体变红-->
			<!--<van-cell-group>
			  <van-field
			    v-model="username"
			    label="用户名"
			    placeholder="请输入用户名"
			    error
			  />
			  <van-field
			    v-model="phone"
			    label="手机号"
			    placeholder="请输入手机号"
			    error-message="手机号格式错误"
			  />
			</van-cell-group>-->
			
			<!--高度自适应-->
			<!--autosize  高度自适应-->
			<!--<van-cell-group>
			  <van-field
			    v-model="message"
			    label="留言"
			    type="textarea"
			    placeholder="请输入留言"
			    rows="1"
			    autosize
			  />
			</van-cell-group>
			-->
			
			
			
			<!--在表单的后面插入按钮-->
			<van-cell-group>
			  <van-field
			    center
			    v-model="sms"
			    label="短信验证码"
			    placeholder="请输入短信验证码"
			    icon="clear"
			    @click-icon="sms = ''"
			  >
			    <van-button slot="button" size="small" type="primary">发送验证码</van-button>
			  </van-field>
			</van-cell-group>
			
	</div>
</template>

<script>
	export default {
	  data() {
	    return {
	    	username:'',
	    	password:''
	    };
	  },
	  
	};
</script>

<style>
</style>