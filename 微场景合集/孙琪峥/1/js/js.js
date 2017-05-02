var swiper = new Swiper('.swiper-container', {
	pagination: '.swiper-pagination',
	paginationClickable: true,
	direction: 'vertical',
	onInit: function(swiper) { //Swiper2.x的初始化是onFirstInit
		swiperAnimateCache(swiper); //隐藏动画元素 
		swiperAnimate(swiper); //初始化完成开始动画
	},
	onSlideChangeEnd: function(swiper) {
		swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
	}
});


window.onload = function() {
	var music = document.getElementById("music");
	var music_gif = music.getElementsByClassName('m')[0];
	var music_off = music.getElementsByClassName('off')[0];
	var bgmusic = music.getElementsByClassName('bgmusic')[0];
	music_sta = 1; //1表示播放中
	music.onclick = function() {
		if (music_sta == 1) {
			music_gif.style.display = 'none'; //让动态背景消失
			//让旋转的音乐图标停止
			music_off.style.transform = 'rotate(0deg)';
			//					停止音乐图标的动画
			music_off.style.animation = 'music 0s';
			//背景音乐消失暂停
			bgmusic.pause();
			music_sta = 0;
		} else {
			music_gif.style.display = 'block'; //让动态背景消失
			//停止音乐图标的动画
			music_off.style.animation = 'music 2s linear infinite';
			//背景音乐继续暂停
			bgmusic.play();
			music_sta = 1;
		}
	}
}