<template>
    <div>
        <!--轮播图-->
        <swiper :options="swiperOption" ref="mySwiper">
            <!-- slides -->
            <swiper-slide v-for="v in slides" :key="v.id">
                <router-link to="/video">
                    <img :src="v.path">
                </router-link>
            </swiper-slide>
            <!-- Optional controls -->
            <div class="swiper-pagination" slot="pagination"></div>
            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next" slot="button-next"></div>
            <div class="swiper-scrollbar" slot="scrollbar"></div>
        </swiper>
        <!--轮播图结束-->
        <!--推荐视频-->
        <h2>推荐视频</h2>
        <div id="recommend">
            <router-link :to="{params:{lessonId:v.id},name:'Page'}" v-for="v in commendLesson" :key="v.id">
                <img :src="v.preview"/>
                <i class="iconfont icon-bofang"></i>
                <span class="time">22:56</span>
                <span class="title">{{v.title}}</span>
            </router-link>
        </div>
        <!--推荐视频结束-->
        <a href="" class="more">MORE ></a>
        <!--今日推荐-->
        <h2>热门视频</h2>
        <div class="today">
            <div class="pic">
                <router-link :to="{params:{lessonId:v.id},name:'Page'}" v-for="v in hotLesson" :key="v.id">
                    <img :src="v.preview">
                </router-link>
            </div>
        </div>
        <div style="height: 100px;"></div>
        <!--今日推荐结束-->
        <!--底部固定导航-->
        <ul id="bottom">
            <li class="cur">
                <router-link to="/">
                    <i class="iconfont icon-shouyeshouye"></i>
                    <span>首页</span>
                </router-link>
            </li>
            <li>
                <router-link to="/video">
                    <i class="iconfont icon-icon02"></i>
                    <span>视频</span>
                </router-link>
            </li>
        </ul>
        <!--底部固定导航结束-->
    </div>
</template>

<script>
    export default {
        name: 'home',
        mounted(){
            //推荐课程
            this.axios.get('http://laravel.hdphp.com/api/commendLesson/4').then((response) => {
                this.commendLesson = response.data.data;
            })
            //热门课程
            this.axios.get('http://laravel.hdphp.com/api/hotLesson/3').then((response) => {
                this.hotLesson = response.data.data;
            })
        },
        data () {
            return {
                //推荐课程
                commendLesson: [],
                //热门课程
                hotLesson:[],
                slides: [
                    {id: 1, path: 'static/images/1.jpg'},
                    {id: 2, path: 'static/images/2.jpg'},
                    {id: 3, path: 'static/images/3.jpg'}
                ],
                swiperOption: {
                    // NotNextTick is a component's own property, and if notNextTick is set to true, the component will not instantiate the swiper through NextTick, which means you can get the swiper object the first time (if you need to use the get swiper object to do what Things, then this property must be true)
                    // notNextTick是一个组件自有属性，如果notNextTick设置为true，组件则不会通过NextTick来实例化swiper，也就意味着你可以在第一时间获取到swiper对象，假如你需要刚加载遍使用获取swiper对象来做什么事，那么这个属性一定要是true
                    notNextTick: true,
                    // swiper configs 所有的配置同swiper官方api配置
                    autoplay: 3000,
//                    direction : 'vertical',
                    grabCursor: true,
                    setWrapperSize: true,
                    autoHeight: true,
                    pagination: '.swiper-pagination',
                    paginationClickable: true,
                    prevButton: '.swiper-button-prev',
                    nextButton: '.swiper-button-next',
                    scrollbar: '.swiper-scrollbar',
                    mousewheelControl: true,
                    observeParents: true,
                }
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    * {
        padding: 0;
        margin: 0;
        color: #31343B;
    }

    a {
        text-decoration: none;
        color: #31343B;;
    }

    li {
        list-style: none;
    }

    body {
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        padding-bottom: 10%;
    }

    .swiper-container {
        width: 100%;
        height: 300px;
    }

    .swiper-slide {
        background: red;
    }

    .swiper-container .swiper-slide a {
        display: block;
        width: 100%;
        height: 100%;
        position: relative;
        /*overflow: hidden;*/
    }

    .swiper-container .swiper-slide img {
        height: 300px;
        width: 100%;
        position: absolute;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
    }

    /*分页器颜色*/
    .swiper-pagination-bullet-active {
        background: rgba(255, 255, 255, 0.6);
    }

    h2 {
        font-size: 4vw;
        text-align: center;
        font-weight: 700;
        line-height: 2em;
        width: 33%;
        margin: 0 auto;
        position: relative;

        margin-top: 4%;
    }

    h2:before {
        content: '◆';
        position: absolute;
        left: 0;
        font-size: 3vw;
    }

    h2:after {
        content: '◆';
        position: absolute;
        right: 0;
        font-size: 3vw;
    }

    /*推荐视频*/
    #recommend {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        width: 92%;
        margin: 0 auto;
    }

    #recommend a {
        width: 48%;
        overflow: hidden;
        display: block;
        margin-top: 4%;
        position: relative;
    }

    #recommend a img {
        width: 100%;
    }

    #recommend a .iconfont.icon-bofang {
        position: absolute;
        color: rgba(255, 255, 255, 1);
        left: 50%;;
        top: 50%;
        font-size: 8vw;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.4);
        border-radius: 50%;
        line-height: 1em;
    }

    #recommend a .time {
        line-height: 1.5em;
        font-size: 3vw;
        color: white;
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        right: 0;
        top: 0;
        padding: 0 2%;
    }

    #recommend a .title {
        position: absolute;
        bottom: 0;
        left: 0;
        line-height: 1.6em;
        color: white;
        text-align: center;
        width: 100%;
        background: linear-gradient(top, transparent, rgba(0, 0, 0, 0.6));
        background: -webkit-linear-gradient(top, transparent, rgba(0, 0, 0, 0.6));
    }

    .more {
        color: #ABB0BC;
        text-align: center;
        line-height: 3em;
        display: block;
        width: 100%;
        border-bottom: 5px solid #ECEEF1;
    }

    /*今日推荐*/
    .today {
        border-top: 1px solid #ECEEF1;
        border-bottom: 1px solid #ECEEF1;
        margin-top: 2%;
        padding-top: 3%;
        padding-bottom: 3%;
        overflow: hidden;
    }

    .today .title {
        margin-left: 4%;
        line-height: 2em;
        font-size: 3.5vw;
        font-weight: 700;
        float: left;
        width: 70%;
    }

    .today .column {
        float: right;
        margin-right: 4%;
        line-height: 2em;
        font-size: 3.5vw;
        color: white;
        background: #FB415F;
        padding: 0 2%;
    }

    .today .pic {
        height: 55vw;
        float: left;
        width: 92%;
        margin-left: 4%;
    }

    .today .pic a {
        display: block;
        float: left;
        overflow: hidden;
        position: relative;
        box-sizing: border-box;
    }

    .today .pic a img {
        min-height: 100%;
        max-height: 120%;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }

    .today .pic a:nth-child(1) {
        width: 60%;
        height: 100%;
        border-right: 4px solid white;
    }

    .today .pic a:nth-child(2) {
        width: 40%;
        height: 50%;
        border-bottom: 4px solid white;
    }

    .today .pic a:nth-child(3) {
        width: 40%;
        height: 50%;
    }

    /*底部固定导航*/
    #bottom {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        display: flex;
        background: #FFFFFF;
        margin: 0;
        border-top: solid 1px #ddd;
    }

    #bottom li {
        width: 50%;
        box-sizing: border-box;
    }

    #bottom li i.iconfont {
        color: #888;
        font-size: 6vw;
        display: block;
        text-align: center;
    }

    #bottom li span {
        font-size: 2.6vw;
        display: block;
        text-align: center;
        color: #888;
    }

    #bottom li.cur {
        /*background: #333;*/
    }

    #bottom li.cur i.iconfont {
        color: #333;
    }

    #bottom li.cur span {
        color: #333;
    }

    /*底部固定导航结束*/
</style>
