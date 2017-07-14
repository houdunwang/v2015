(function (window) {
    util = {
        //获取get参数值
        get: function (par) {
            //获取当前URL
            var local_url = document.location.href;
            //获取要取得的get参数位置
            var get = local_url.indexOf(par + "=");
            if (get == -1) {
                return false;
            }
            //截取字符串
            var get_par = local_url.slice(par.length + get + 1);
            //判断截取后的字符串是否还有其他get参数
            var nextPar = get_par.indexOf("&");
            if (nextPar != -1) {
                get_par = get_par.slice(0, nextPar);
            }
            return get_par;
        },
        //替换get参数
        getReplace: function (paramName, replaceWith) {
            var oUrl = location.href.toString();
            if (oUrl.indexOf(paramName) >= 0) {
                var re = eval('/(' + paramName + '=)([^&]*)/gi');
                return oUrl.replace(re, paramName + '=' + replaceWith);
            } else {
                return oUrl + '&' + paramName + '=' + replaceWith;
            }
        },
        zclip: function (elem, content, callback) {
            if (elem.clip) {
                return;
            }
            require(['jquery.zclip'], function () {
                $(elem).zclip({
                    path: hdjs.base + '/component/zclip/ZeroClipboard.swf',
                    copy: $.trim(content),
                    afterCopy: function () {
                        if ($.isFunction(callback)) {
                            return callback(elem, content);
                        } else {
                            obj = $(elem).next('.hdJsCopyElem');
                            if (obj.length == 0) {
                                obj = $('<em class="hdJsCopyElem">&nbsp;<span class="label label-success"><i class="fa fa-check-circle"></i> 复制成功</span></em>');
                                var enext = $(elem).next().html();
                                $(elem).after(obj);
                            }
                            setTimeout(function () {
                                obj.remove();
                            }, 2000);
                        }
                    }
                });
                elem.clip = true;
            });
        },
        //表情
        emotion: function (options) {
            require(['caret', 'bootstrap', 'css!../css/emotion.css'], function ($) {
                $(function () {
                    var emotions_html = '<table class="emotions" cellspacing="0" cellpadding="0"><tbody><tr><td><div class="eItem" style="background-position:0px 0;" data-title="微笑" data-code="微笑" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/0.gif"></div></td><td><div class="eItem" style="background-position:-24px 0;" data-title="撇嘴" data-code="撇嘴" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/1.gif"></div></td><td><div class="eItem" style="background-position:-48px 0;" data-title="色" data-code="色" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/2.gif"></div></td><td><div class="eItem" style="background-position:-72px 0;" data-title="发呆" data-code="发呆" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/3.gif"></div></td><td><div class="eItem" style="background-position:-96px 0;" data-title="得意" data-code="得意" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/4.gif"></div></td><td><div class="eItem" style="background-position:-120px 0;" data-title="流泪" data-code="流泪" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/5.gif"></div></td><td><div class="eItem" style="background-position:-144px 0;" data-title="害羞" data-code="害羞" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/6.gif"></div></td><td><div class="eItem" style="background-position:-168px 0;" data-title="闭嘴" data-code="闭嘴" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/7.gif"></div></td><td><div class="eItem" style="background-position:-192px 0;" data-title="睡" data-code="睡" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/8.gif"></div></td><td><div class="eItem" style="background-position:-216px 0;" data-title="大哭" data-code="大哭" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/9.gif"></div></td><td><div class="eItem" style="background-position:-240px 0;" data-title="尴尬" data-code="尴尬" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/10.gif"></div></td><td><div class="eItem" style="background-position:-264px 0;" data-title="发怒" data-code="发怒" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/11.gif"></div></td><td><div class="eItem" style="background-position:-288px 0;" data-title="调皮" data-code="调皮" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/12.gif"></div></td><td><div class="eItem" style="background-position:-312px 0;" data-title="呲牙" data-code="呲牙" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/13.gif"></div></td><td><div class="eItem" style="background-position:-336px 0;" data-title="惊讶" data-code="惊讶" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/14.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-360px 0;" data-title="难过" data-code="难过" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/15.gif"></div></td><td><div class="eItem" style="background-position:-384px 0;" data-title="酷" data-code="酷" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/16.gif"></div></td><td><div class="eItem" style="background-position:-408px 0;" data-title="冷汗" data-code="冷汗" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/17.gif"></div></td><td><div class="eItem" style="background-position:-432px 0;" data-title="抓狂" data-code="抓狂" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/18.gif"></div></td><td><div class="eItem" style="background-position:-456px 0;" data-title="吐" data-code="吐" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/19.gif"></div></td><td><div class="eItem" style="background-position:-480px 0;" data-title="偷笑" data-code="偷笑" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/20.gif"></div></td><td><div class="eItem" style="background-position:-504px 0;" data-title="可爱" data-code="可爱" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/21.gif"></div></td><td><div class="eItem" style="background-position:-528px 0;" data-title="白眼" data-code="白眼" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/22.gif"></div></td><td><div class="eItem" style="background-position:-552px 0;" data-title="傲慢" data-code="傲慢" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/23.gif"></div></td><td><div class="eItem" style="background-position:-576px 0;" data-title="饥饿" data-code="饥饿" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/24.gif"></div></td><td><div class="eItem" style="background-position:-600px 0;" data-title="困" data-code="困" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/25.gif"></div></td><td><div class="eItem" style="background-position:-624px 0;" data-title="惊恐" data-code="惊恐" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/26.gif"></div></td><td><div class="eItem" style="background-position:-648px 0;" data-title="流汗" data-code="流汗" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/27.gif"></div></td><td><div class="eItem" style="background-position:-672px 0;" data-title="憨笑" data-code="憨笑" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/28.gif"></div></td><td><div class="eItem" style="background-position:-696px 0;" data-title="大兵" data-code="大兵" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/29.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-720px 0;" data-title="奋斗" data-code="奋斗" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/30.gif"></div></td><td><div class="eItem" style="background-position:-744px 0;" data-title="咒骂" data-code="咒骂" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/31.gif"></div></td><td><div class="eItem" style="background-position:-768px 0;" data-title="疑问" data-code="疑问" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/32.gif"></div></td><td><div class="eItem" style="background-position:-792px 0;" data-title="嘘" data-code="嘘" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/33.gif"></div></td><td><div class="eItem" style="background-position:-816px 0;" data-title="晕" data-code="晕" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/34.gif"></div></td><td><div class="eItem" style="background-position:-840px 0;" data-title="折磨" data-code="折磨" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/35.gif"></div></td><td><div class="eItem" style="background-position:-864px 0;" data-title="衰" data-code="衰" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/36.gif"></div></td><td><div class="eItem" style="background-position:-888px 0;" data-title="骷髅" data-code=":!!!" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/37.gif"></div></td><td><div class="eItem" style="background-position:-912px 0;" data-title="敲打" data-code="敲打" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/38.gif"></div></td><td><div class="eItem" style="background-position:-936px 0;" data-title="再见" data-code="再见" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/39.gif"></div></td><td><div class="eItem" style="background-position:-960px 0;" data-title="擦汗" data-code="擦汗" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/40.gif"></div></td><td><div class="eItem" style="background-position:-984px 0;" data-title="抠鼻" data-code="抠鼻" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/41.gif"></div></td><td><div class="eItem" style="background-position:-1008px 0;" data-title="鼓掌" data-code="鼓掌" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/42.gif"></div></td><td><div class="eItem" style="background-position:-1032px 0;" data-title="糗大了" data-code="糗大了" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/43.gif"></div></td><td><div class="eItem" style="background-position:-1056px 0;" data-title="坏笑" data-code="坏笑" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/44.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1080px 0;" data-title="左哼哼" data-code="左哼哼" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/45.gif"></div></td><td><div class="eItem" style="background-position:-1104px 0;" data-title="右哼哼" data-code="右哼哼" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/46.gif"></div></td><td><div class="eItem" style="background-position:-1128px 0;" data-title="哈欠" data-code="哈欠" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/47.gif"></div></td><td><div class="eItem" style="background-position:-1152px 0;" data-title="鄙视" data-code="鄙视" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/48.gif"></div></td><td><div class="eItem" style="background-position:-1176px 0;" data-title="委屈" data-code="委屈" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/49.gif"></div></td><td><div class="eItem" style="background-position:-1200px 0;" data-title="快哭了" data-code="快哭了" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/50.gif"></div></td><td><div class="eItem" style="background-position:-1224px 0;" data-title="阴险" data-code="阴险" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/51.gif"></div></td><td><div class="eItem" style="background-position:-1248px 0;" data-title="亲亲" data-code="亲亲" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/52.gif"></div></td><td><div class="eItem" style="background-position:-1272px 0;" data-title="吓" data-code="吓" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/53.gif"></div></td><td><div class="eItem" style="background-position:-1296px 0;" data-title="可怜" data-code="可怜" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/54.gif"></div></td><td><div class="eItem" style="background-position:-1320px 0;" data-title="菜刀" data-code="菜刀" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/55.gif"></div></td><td><div class="eItem" style="background-position:-1344px 0;" data-title="西瓜" data-code="西瓜" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/56.gif"></div></td><td><div class="eItem" style="background-position:-1368px 0;" data-title="啤酒" data-code="啤酒" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/57.gif"></div></td><td><div class="eItem" style="background-position:-1392px 0;" data-title="篮球" data-code="篮球" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/58.gif"></div></td><td><div class="eItem" style="background-position:-1416px 0;" data-title="乒乓" data-code="乒乓" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/59.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1440px 0;" data-title="咖啡" data-code="咖啡" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/60.gif"></div></td><td><div class="eItem" style="background-position:-1464px 0;" data-title="饭" data-code="饭" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/61.gif"></div></td><td><div class="eItem" style="background-position:-1488px 0;" data-title="猪头" data-code="猪头" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/62.gif"></div></td><td><div class="eItem" style="background-position:-1512px 0;" data-title="玫瑰" data-code="玫瑰" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/63.gif"></div></td><td><div class="eItem" style="background-position:-1536px 0;" data-title="凋谢" data-code="凋谢" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/64.gif"></div></td><td><div class="eItem" style="background-position:-1560px 0;" data-title="示爱" data-code="示爱" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/65.gif"></div></td><td><div class="eItem" style="background-position:-1584px 0;" data-title="爱心" data-code="爱心" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/66.gif"></div></td><td><div class="eItem" style="background-position:-1608px 0;" data-title="心碎" data-code="心碎" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/67.gif"></div></td><td><div class="eItem" style="background-position:-1632px 0;" data-title="蛋糕" data-code="蛋糕" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/68.gif"></div></td><td><div class="eItem" style="background-position:-1656px 0;" data-title="闪电" data-code="闪电" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/69.gif"></div></td><td><div class="eItem" style="background-position:-1680px 0;" data-title="炸弹" data-code="炸弹" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/70.gif"></div></td><td><div class="eItem" style="background-position:-1704px 0;" data-title="刀" data-code="刀" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/71.gif"></div></td><td><div class="eItem" style="background-position:-1728px 0;" data-title="足球" data-code="足球" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/72.gif"></div></td><td><div class="eItem" style="background-position:-1752px 0;" data-title="瓢虫" data-code="瓢虫" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/73.gif"></div></td><td><div class="eItem" style="background-position:-1776px 0;" data-title="便便" data-code="便便" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/74.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-1800px 0;" data-title="月亮" data-code="月亮" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/75.gif"></div></td><td><div class="eItem" style="background-position:-1824px 0;" data-title="太阳" data-code="太阳" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/76.gif"></div></td><td><div class="eItem" style="background-position:-1848px 0;" data-title="礼物" data-code="礼物" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/77.gif"></div></td><td><div class="eItem" style="background-position:-1872px 0;" data-title="拥抱" data-code="拥抱" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/78.gif"></div></td><td><div class="eItem" style="background-position:-1896px 0;" data-title="强" data-code="强" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/79.gif"></div></td><td><div class="eItem" style="background-position:-1920px 0;" data-title="弱" data-code="弱" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/80.gif"></div></td><td><div class="eItem" style="background-position:-1944px 0;" data-title="握手" data-code="握手" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/81.gif"></div></td><td><div class="eItem" style="background-position:-1968px 0;" data-title="胜利" data-code="胜利" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/82.gif"></div></td><td><div class="eItem" style="background-position:-1992px 0;" data-title="抱拳" data-code="抱拳" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/83.gif"></div></td><td><div class="eItem" style="background-position:-2016px 0;" data-title="勾引" data-code="勾引" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/84.gif"></div></td><td><div class="eItem" style="background-position:-2040px 0;" data-title="拳头" data-code="拳头" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/85.gif"></div></td><td><div class="eItem" style="background-position:-2064px 0;" data-title="差劲" data-code="差劲" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/86.gif"></div></td><td><div class="eItem" style="background-position:-2088px 0;" data-title="爱你" data-code="爱你" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/87.gif"></div></td><td><div class="eItem" style="background-position:-2112px 0;" data-title="NO" data-code="NO" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/88.gif"></div></td><td><div class="eItem" style="background-position:-2136px 0;" data-title="OK" data-code="OK" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/89.gif"></div></td></tr><tr><td><div class="eItem" style="background-position:-2160px 0;" data-title="爱情" data-code="爱情" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/90.gif"></div></td><td><div class="eItem" style="background-position:-2184px 0;" data-title="飞吻" data-code="飞吻" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/91.gif"></div></td><td><div class="eItem" style="background-position:-2208px 0;" data-title="跳跳" data-code="跳跳" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/92.gif"></div></td><td><div class="eItem" style="background-position:-2232px 0;" data-title="发抖" data-code="发抖" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/93.gif"></div></td><td><div class="eItem" style="background-position:-2256px 0;" data-title="怄火" data-code="怄火" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/94.gif"></div></td><td><div class="eItem" style="background-position:-2280px 0;" data-title="转圈" data-code="转圈" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/95.gif"></div></td><td><div class="eItem" style="background-position:-2304px 0;" data-title="磕头" data-code="磕头" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/96.gif"></div></td><td><div class="eItem" style="background-position:-2328px 0;" data-title="回头" data-code="回头" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/97.gif"></div></td><td><div class="eItem" style="background-position:-2352px 0;" data-title="跳绳" data-code="跳绳" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/98.gif"></div></td><td><div class="eItem" style="background-position:-2376px 0;" data-title="挥手" data-code="挥手" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/99.gif"></div></td><td><div class="eItem" style="background-position:-2400px 0;" data-title="激动" data-code="激动" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/100.gif"></div></td><td><div class="eItem" style="background-position:-2424px 0;" data-title="街舞" data-code="街舞" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/101.gif"></div></td><td><div class="eItem" style="background-position:-2448px 0;" data-title="献吻" data-code="献吻" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/102.gif"></div></td><td><div class="eItem" style="background-position:-2472px 0;" data-title="左太极" data-code="左太极" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/103.gif"></div></td><td><div class="eItem" style="background-position:-2496px 0;" data-title="右太极" data-code="右太极" data-gifurl="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/104.gif"></div></td></tr></tbody></table><div class="emotionsGif" style=""></div>';
                    var btn = options.btn;
                    var input = options.input;
                    $(btn).popover({
                        html: true,
                        content: emotions_html,
                        placement: "bottom"
                    });
                    $(btn).one('shown.bs.popover', function () {
                        //显示表情图标预览小方框
                        $(btn).next().delegate(".eItem", "mouseover", function () {
                            var emo_img = '<img src="' + $(this).attr("data-gifurl") + '" alt="mo-' + $(this).attr("data-title") + '" />';
                            var emo_txt = '/' + $(this).attr("data-code");
                            $(btn).next().find(".emotionsGif").html(emo_img);
                        });
                        $(btn).next().delegate(".eItem", "click", function () {
                            var pos = $(input).caret();
                            $(input).caret(pos);
                            var emo_txt = '/' + $(this).attr("data-code");
                            var content = $(input).val();
                            var res = content.substr(0, pos);
                            var replaceText = content.substr(0, pos) + emo_txt + content.substr(pos);
                            $(input).val(content.replace(content, replaceText));
                            //$(btn).popover('hide');
                            //隐藏表情弹出框
                            $(btn).trigger('click');
                            if ($.isFunction(options.callback)) {
                                options.callback(emo_txt, btn, input);
                            }
                        });
                    });
                });
            });
        },
        //图表
        chart: function (opt) {
            var options = $.extend({}, opt);
            require(['chart'], function (Chart) {
                    var ctx = $(options.element)[0].getContext("2d"), myNewChart;
                    switch (options.type) {
                        case 'Line'://曲线图
                            myNewChart = new Chart(ctx).Line(options.data);
                            break;
                        case 'Bar'://柱状图
                            myNewChart = new Chart(ctx).Bar(options.data);
                            break;
                        case 'Radar'://雷达图或蛛网图
                            myNewChart = new Chart(ctx).Radar(options.data);
                            break;
                        case 'PolarArea'://极地区域图
                            myNewChart = new Chart(ctx).PolarArea(options.data);
                            break;
                        case 'Pie'://饼图
                            myNewChart = new Chart(ctx).Pie(options.data);
                            break;
                        case 'Doughnut'://环形图
                            myNewChart = new Chart(ctx).Doughnut(options.data);
                            break;
                    }
                }
            )
        },
        //拾色器
        colorpicker: function (opt) {
            var options = $.extend({}, opt);
            require(['colorpicker'], function () {
                    $(options.element).spectrum(
                        {
                            className: "colorpicker",
                            showInput: true,
                            showInitial: true,
                            showPalette: true,
                            maxPaletteSize: 10,
                            preferredFormat: "hex",
                            chooseText: "确定",
                            cancelText: "关闭",
                            change: function (color) {
                                if ($.isFunction(options.callback)) {
                                    options.callback(color + '');
                                }
                            },
                            palette: [
                                [
                                    "rgb(0, 0, 0)",
                                    "rgb(67, 67, 67)",
                                    "rgb(102, 102, 102)",
                                    "rgb(153, 153, 153)",
                                    "rgb(183, 183, 183)",
                                    "rgb(204, 204, 204)",
                                    "rgb(217, 217, 217)",
                                    "rgb(239, 239, 239)",
                                    "rgb(243, 243, 243)",
                                    "rgb(255, 255, 255)"
                                ],
                                [
                                    "rgb(152, 0, 0)",
                                    "rgb(255, 0, 0)",
                                    "rgb(255, 153, 0)",
                                    "rgb(255, 255, 0)",
                                    "rgb(0, 255, 0)",
                                    "rgb(0, 255, 255)",
                                    "rgb(74, 134, 232)",
                                    "rgb(0, 0, 255)",
                                    "rgb(153, 0, 255)",
                                    "rgb(255, 0, 255)"
                                ],
                                [
                                    "rgb(230, 184, 175)",
                                    "rgb(244, 204, 204)",
                                    "rgb(252, 229, 205)",
                                    "rgb(255, 242, 204)",
                                    "rgb(217, 234, 211)",
                                    "rgb(208, 224, 227)",
                                    "rgb(201, 218, 248)",
                                    "rgb(207, 226, 243)",
                                    "rgb(217, 210, 233)",
                                    "rgb(234, 209, 220)",
                                    "rgb(221, 126, 107)",
                                    "rgb(234, 153, 153)",
                                    "rgb(249, 203, 156)",
                                    "rgb(255, 229, 153)",
                                    "rgb(182, 215, 168)",
                                    "rgb(162, 196, 201)",
                                    "rgb(164, 194, 244)",
                                    "rgb(159, 197, 232)",
                                    "rgb(180, 167, 214)",
                                    "rgb(213, 166, 189)",
                                    "rgb(204, 65, 37)",
                                    "rgb(224, 102, 102)",
                                    "rgb(246, 178, 107)",
                                    "rgb(255, 217, 102)",
                                    "rgb(147, 196, 125)",
                                    "rgb(118, 165, 175)",
                                    "rgb(109, 158, 235)",
                                    "rgb(111, 168, 220)",
                                    "rgb(142, 124, 195)",
                                    "rgb(194, 123, 160)",
                                    "rgb(166, 28, 0)",
                                    "rgb(204, 0, 0)",
                                    "rgb(230, 145, 56)",
                                    "rgb(241, 194, 50)",
                                    "rgb(106, 168, 79)",
                                    "rgb(69, 129, 142)",
                                    "rgb(60, 120, 216)",
                                    "rgb(61, 133, 198)",
                                    "rgb(103, 78, 167)",
                                    "rgb(166, 77, 121)",
                                    "rgb(133, 32, 12)",
                                    "rgb(153, 0, 0)",
                                    "rgb(180, 95, 6)",
                                    "rgb(191, 144, 0)",
                                    "rgb(56, 118, 29)",
                                    "rgb(19, 79, 92)",
                                    "rgb(17, 85, 204)",
                                    "rgb(11, 83, 148)",
                                    "rgb(53, 28, 117)",
                                    "rgb(116, 27, 71)",
                                    "rgb(91, 15, 0)",
                                    "rgb(102, 0, 0)",
                                    "rgb(120, 63, 4)",
                                    "rgb(127, 96, 0)",
                                    "rgb(39, 78, 19)",
                                    "rgb(12, 52, 61)",
                                    "rgb(28, 69, 135)",
                                    "rgb(7, 55, 99)",
                                    "rgb(32, 18, 77)",
                                    "rgb(76, 17, 48)"
                                ]
                            ]
                        }
                    );
                }
            );
        },

        //日历选项
        datetimepicker: function (opt) {
            var options = $.extend({
                locale: 'zh-CN',//中文
                format: 'YYYY-M-D H:m',//格式
                showTodayButton: true,//显示今天
            }, opt.options)
            require(['datetimepicker'], function () {
                    $(opt.element).datetimepicker(options);
                }
            );
        },
        //日期区间
        daterangepicker: function (opt) {
            var options = $.extend({
                "autoApply": true,//自动关闭,有timePicker属性时无效
                "locale": {
                    "format": "YYYY/MM/DD",//YYYY/MM/DD H:m
                    "separator": " 至 ",
                    "applyLabel": "确定",
                    "cancelLabel": "取消",
                    "fromLabel": "From",
                    "daysOfWeek": [
                        "日", "一", "二", "三", "四", "五", "六"
                    ],
                    "monthNames": [
                        "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"
                    ],
                    "firstDay": 0
                },
            }, opt);

            require(['bootstrap', 'daterangepicker'], function ($) {
                    $(opt.element).daterangepicker(options, function (start, end, label) {
                        if (opt.callback) {
                            opt.callback(start, end, label)
                        }
                    });
                }
            )
        },
        //日期区间列表
        daterangepickerList: function (opt) {
            require(['moment', 'daterangepicker'], function (moment) {
                    var options = $.extend({
                        //"timePicker": true,//显示时间
                        //"timePicker24Hour": true,//24小时制
                        //"autoApply": true,//自动关闭,有timePicker属性时无效
                        "locale": {
                            "format": "YYYY/MM/DD",//YYYY/MM/DD H:m
                            "separator": " 至 ",
                            "applyLabel": "确定",
                            "cancelLabel": "取消",
                            "fromLabel": "From",
                            "daysOfWeek": [
                                "日", "一", "二", "三", "四", "五", "六"
                            ],
                            "monthNames": [
                                "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"
                            ],
                            "firstDay": 0,
                            "customRangeLabel": '日期范围'
                        },
                        ranges: {
                            '今天': [moment(), moment()],
                            '一周内': [moment().subtract(6, 'days'), moment()],
                            '二周内': [moment().subtract(29, 'days'), moment()],
                            '一月内': [moment().startOf('month'), moment().endOf('month')],
                            '上个月': [
                                moment().subtract(1, 'month').startOf('month'),
                                moment().subtract(1, 'month').endOf('month')
                            ]
                        }
                    }, opt.options);

                    $(opt.element).daterangepicker(options, function (start, end, label) {
                        if (opt.callback) {
                            opt.callback(start, end, label)
                        }
                    });
                }
            )
        },
        //时间选择
        clockpicker: function (opt) {
            require(['clockpicker'], function () {
                    $(opt.element).clockpicker(opt.options);
                }
            );
        },
        //ueditor.md 编辑器
        editormd: function (opt) {
            var options = $.extend({
                id: '',
                width: "100%",
                height: 300,
                syncScrolling: "single",
                path: hdjs.base + "/component/editormd/lib/"
            }, opt);
            var deps = [
                "editormd",
                "../component/editormd/languages/en",
                "../component/editormd/plugins/link-dialog/link-dialog",
                "../component/editormd/plugins/reference-link-dialog/reference-link-dialog",
                "../component/editormd/plugins/image-dialog/image-dialog",
                "../component/editormd/plugins/code-block-dialog/code-block-dialog",
                "../component/editormd/plugins/table-dialog/table-dialog",
                "../component/editormd/plugins/emoji-dialog/emoji-dialog",
                "../component/editormd/plugins/goto-line-dialog/goto-line-dialog",
                "../component/editormd/plugins/help-dialog/help-dialog",
                "../component/editormd/plugins/html-entities-dialog/html-entities-dialog",
                "../component/editormd/plugins/preformatted-text-dialog/preformatted-text-dialog"
            ];
            var testEditor;
            require(deps, function (editormd) {
                editormd.loadCSS(hdjs.base + "/component/editormd/lib/codemirror/addon/fold/foldgutter");
                testEditor = editormd(options.id, options);

            });
        },
        //百度编辑器
        ueditor: function (id, opt, callback) {
            require(['ueditor', 'ZeroClipboard', 'jquery'], function (ueditor, ZeroClipboard, $) {
                window.ZeroClipboard = ZeroClipboard;
                var options = $.extend({
                    UEDITOR_HOME_URL: hdjs.base + '/component/ueditor/',
                    serverUrl: hdjs.ueditor,
                    'elementPathEnabled': false,
                    'initialFrameHeight': 200,
                    'focus': false,
                    'maximumWords': 9999999999999,
                    'autoClearinitialContent': false,
                    'toolbars': [['fullscreen', 'source', 'preview', '|', 'bold', 'italic', 'underline', 'strikethrough', 'forecolor', 'backcolor', '|',
                        'justifyleft', 'justifycenter', 'justifyright', '|', 'insertorderedlist', 'insertunorderedlist', 'blockquote', 'emotion',
                        'link', 'removeformat', '|', 'rowspacingtop', 'rowspacingbottom', 'lineheight', 'indent', 'paragraph', 'fontsize', '|',
                        'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol',
                        'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', '|', 'map', 'print', 'drafts']],
                    autoHeightEnabled: false,//自动增高
                    autoFloatEnabled: false,
                }, opt);
                UE.registerUI('button', function (editor, uiName) {
                    //注册按钮执行时的command命令，使用命令默认就会带有回退操作
                    editor.registerCommand(uiName, {
                        execCommand: function () {
                            require(['bootstrap', 'fileUploader'], function ($, fileUploader) {
                                var opts = {
                                    type: 'image',
                                    multiple: true,
                                    extensions: 'gif,jpg,jpeg,bmp,png',
                                };
                                fileUploader.show(function (imgs) {
                                    if (imgs.length == 0) {
                                        return;
                                    } else {
                                        var imglist = [];
                                        for (i in imgs) {
                                            imglist.push({
                                                'src': imgs[i],
                                                'max-width': '100%',
                                            });
                                        }
                                        editor.execCommand('insertimage', imglist);
                                    }
                                }, opts);
                            });
                        }
                    });
                    //创建一个button
                    var btn = new UE.ui.Button({
                        //按钮的名字
                        name: uiName,
                        //提示
                        title: uiName,
                        //添加额外样式，指定icon图标，这里默认使用一个重复的icon
                        cssRules: 'background-position: -726px -77px',
                        //点击时执行的命令
                        onclick: function () {
                            //这里可以不用执行命令,做你自己的操作也可
                            editor.execCommand(uiName);
                        }
                    });
                    //当点到编辑内容上时，按钮要做的状态反射
                    editor.addListener('selectionchange', function () {
                        var state = editor.queryCommandState(uiName);
                        if (state == -1) {
                            btn.setDisabled(true);
                            btn.setChecked(false);
                        } else {
                            btn.setDisabled(false);
                            btn.setChecked(state);
                        }
                    });
                    //因为你是添加button,所以需要返回这个button
                    return btn;
                }, 19);
                var editor = UE.getEditor(id, options);
                if ($.isFunction(callback)) {
                    callback(editor);
                }
            });
        },
        //加载动画
        loading: function (opt) {
            var modalobj = $('#modal-loading');
            if (modalobj.length == 0) {
                $(document.body).append('<div id="modal-loading" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"></div>');
                modalobj = $('#modal-loading');
                html =
                    '<div class="modal-dialog">' +
                    '	<div style="text-align:center; background-color: transparent;">' +
                    '		<img style="width:48px; height:48px; margin-top:100px;" ' +
                    'src="' + hdjs.base + '/images/loading.gif" title="正在努力加载...">' +
                    '	</div>' +
                    '</div>';
                modalobj.html(html);
            }
            modalobj.modal('show');
            modalobj.next().css('z-index', 999999);
            return modalobj;
        },
        //提交post数据
        post: function (opt) {
            var options = $.extend({
                url: '',
                data: {},
                success: function () {
                },
                error: function () {
                }
            }, opt);
            $.post(options.url, options.data, function (json) {
                if ($.isFunction(options.callback)) {
                    options.callback(json);
                }
            }, 'json')
        },
        /**
         * 异步发送表单
         * @param options
         */
        submit: function (opt) {
            var options = $.extend({
                el: 'form',
                url: window.system ? window.system.url : '',
                data: '',
                successUrl: 'back',
                callback: '',
            }, opt);
            require(['util', 'jquery', 'underscore'], function (util, $, _) {
                var data = options.data == '' ? $(options.el).serialize() : options.data;
                $.ajax({
                    url: options.url,
                    type: 'post',
                    cache: false,
                    data: data,
                    dataType: "json",
                    success: function (json) {
                        if (_.isObject(json)) {
                            if ($.isFunction(options.callback)) {
                                options.callback(json);
                            } else {
                                if (json.valid == 1) {
                                    util.message(json.message, options.successUrl, 'success');
                                } else {
                                    util.message(json.message, '', 'info');
                                }
                            }
                        } else {
                            util.message(json, '', 'error');
                        }
                    }
                });
                return false;
            });
        },
        //字休文件模态
        font: function (callback) {
            var modalobj = util.modal({
                title: '选择图标',
                width: 700,
                content: ['?s=component/font/lists',{user_type:window.system.user_type}],
                footer: '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>'
            })
            window.selectIconComplete = function (ico) {
                callback(ico);
                modalobj.modal('hide');
            };
        },
        //消息提示
        message: function (msg, redirect, type, timeout, options) {
            if ($.isArray(msg)) {
                msg = msg.join('<br/>');
            }
            timeout = timeout ? timeout : 3;
            if (!redirect && !type) {
                type = 'info';
            }
            if ($.inArray(type, ['success', 'error', 'info', 'warning']) == -1) {
                type = '';
            }
            if (type == '') {
                type = redirect == '' ? 'error' : 'success';
            }
            var icons = {
                success: 'check-circle',
                error: 'times-circle',
                info: 'info-circle',
                warning: 'exclamation-triangle'
            };
            switch (type) {
                case 'success':
                    fa = 'fa-check-circle';
                    break;
                case 'warning':
                    fa = 'fa-warning';
                    break;
                case 'error':
                    fa = 'fa-times-circle';
                    break;
                case 'info':
                    fa = 'fa-info-circle';
                    break;
            }
            var h = '';
            if (redirect && redirect.length > 0) {
                if (redirect == 'back') {
                    h = '<p><a href="javascript:;" onclick="history.go(-1)" target="main" data-dismiss="modal" aria-hidden="true">如果你的浏览器在 <span id="timeout">' + timeout + '</span> 秒后没有自动跳转，请点击此链接</a></p>';
                    redirect = document.referrer;
                } else if (redirect == 'refresh') {
                    redirect = location.href;
                    h = '<p><a href="' + redirect + '" target="main" data-dismiss="modal" aria-hidden="true">系统将在 <span id="timeout"></span> 秒后刷新页面</a></p>';
                } else {
                    h = '<p><a href="' + redirect + '" target="main" data-dismiss="modal" aria-hidden="true">如果你的浏览器在 <span id="timeout">' + timeout + '</span> 秒后没有自动跳转，请点击此链接</a></p>';
                }
            }
            var content =
                '			<i class="pull-left fa fa-4x fa-' + icons[type] + '"></i>' +
                '			<div class="pull-left"><p>' + msg + '</p>' + h +
                '			</div>' +
                '			<div class="clearfix"></div>';
            var footer =
                '			<button type="button" class="btn btn-default" data-dismiss="modal">确认</button>';

            var modalobj = util.modal($.extend({
                title: '系统提示',
                content: content,
                footer: footer,
                id: 'modalMessage'
            }, options));
            modalobj.find('.modal-content').addClass('alert alert-' + type);
            if (redirect) {
                var timer = '';
                modalobj.find("#timeout").html(timeout);
                modalobj.on('show.bs.modal', function () {
                    doredirect();
                });
                modalobj.on('hide.bs.modal', function () {
                    timeout = 0;
                    doredirect();
                });
                modalobj.on('hidden.bs.modal', function () {
                    modalobj.remove();
                });
                function doredirect() {
                    timer = setTimeout(function () {
                        if (timeout <= 0) {
                            modalobj.modal('hide');
                            clearTimeout(timer);
                            window.location.href = redirect;
                            return;
                        } else {
                            timeout--;
                            modalobj.find("#timeout").html(timeout);
                            doredirect();
                        }
                    }, 1000);
                }
            }
            modalobj.modal('show');
            return modalobj;
        },
        //确认提示框
        confirm: function (content, callback, options) {
            var content =
                '			<i class="pull-left fa fa-4x fa-info-circle"></i>' +
                '			<div class="pull-left"><p>' + content + '</p>' +
                '			</div>' +
                '			<div class="clearfix"></div>';
            var modalobj = util.modal($.extend({
                title: '系统提示',
                content: content,
                footer: '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
                '<button type="button" class="btn btn-primary confirm">确定</button>',
                events: {
                    confirm: function () {
                        if ($.isFunction(callback)) {
                            modalobj.modal('hide');
                            callback();
                        }
                    }
                }
            }, options));
            modalobj.find('.modal-content').addClass('alert alert-info');
            return modalobj;
        },
        //显示模态框
        modal: function (options) {
            var opt = $.extend({
                title: '',//标题
                content: '',//内容
                footer: '',//底部
                id: 'hdMessage',//模态框id
                width: 600,//宽度
                class: '',//样式
                option: {},//bootstrap模态框选项
                events: {},//事件,参考bootstrap
            }, options);
            var modalObj = $("#" + opt.id);
            if (modalObj.length == 0) {
                $(document.body).append('<div class="modal fade" id="' + opt.id + '"role="dialog" tabindex="-1" role="dialog" aria-hidden="true"></div>');
                modalObj = $("#" + opt.id);
            }
            var html = '<div class="modal-dialog" role="document">' +
                '<div class="modal-content ' + opt.class + '">';
            if (opt.title) {
                html += '<div class="modal-header">'
                    + '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                    + '<span aria-hidden="true">&times;</span></button>'
                    + '<h4 class="modal-title">' + opt.title + '</h4></div>';
            }
            //模态框内容
            if (opt.content) {
                if (!$.isArray(opt.content)) {
                    html += '<div class="modal-body">' + opt.content + '</div>';
                } else {
                    html += '<div class="modal-body">正在加载中...</div>';
                }
            }
            if (opt.footer) {
                html += '<div class="modal-footer">' + opt.footer + '</div>';
            }
            html += "</div></div>";
            modalObj.html(html);
            if (opt.width) {
                modalObj.find('.modal-dialog').css({width: opt.width});
            }
            if (opt.content && $.isArray(opt.content)) {
                //将异步加载内容放入模态体中
                var callback = function (d) {
                    modalObj.find('.modal-body').html(d);
                }
                if (opt.content.length == 2) {
                    $.post(opt.content[0], opt.content[1]).done(callback);
                } else {
                    $.get(opt.content[0]).done(callback);
                }
            }
            //绑定模态事件
            $(opt.events).each(function (i) {
                for (name in opt.events) {
                    if (typeof opt.events[name] == 'function') {
                        modalObj.on(name, opt.events[name]);
                    }
                }
            });
            //点击确定按钮事件
            if (typeof opt.events['confirm'] == 'function') {
                modalObj.find('.confirm', modalObj).on('click', function () {
                    options.events['confirm'](modalObj);
                    //隐藏模态框
                    modalObj.modal('hide');
                });
            }
            //关闭模态框时删除他
            modalObj.on('hidden.bs.modal', function () {
                modalObj.remove();
            });
            /**
             * 有确定按钮时添加事件
             * 当点击确定时删除模态框
             */
            modalObj.on('hidden.bs.modal', function () {
                modalObj.remove();
            });
            //点击取消按钮事件
            if (typeof opt.events['cancel'] == 'function') {
                modalObj.find('.cancel', modalObj).on('click', function () {
                    options.events['cancel'](modalObj);
                });
            }
            return modalObj.modal(opt);
        },

        //模态框提交表单
        ajaxShow: function (url, options) {
            var defaultOptions = $.extend({}, options);
            var opt = $.extend({
                id: 'ajaxshow',
                title: '系统提示',
                show: true,
                events: {},
                options: defaultOptions,
                content: '正在加载中...'
            }, options);

            //底部按钮
            opt.footer = (typeof opt.events['confirm'] == 'function' ? '<a href="#" class="btn btn-primary confirm">确定</a>' : '') + '<a href="#" class="btn cancel" data-dismiss="modal" aria-hidden="true">关闭</a><iframe id="_formtarget" style="display:none;" name="_formtarget"></iframe>';
            var modalObj = this.modal(opt);
            modalObj.find('.modal-body').load(url, function () {
                $('form.ajaxfrom').each(function () {
                    $(this).attr('action', $(this).attr('action') + '&isajax=1&target=formtarget');
                    $(this).attr('target', '_formtarget');
                })
            });
            modalObj.on('hidden.bs.modal', function () {
                modalObj.remove();
            });

            return modalObj;
        },
        //上传图片
        image: function (callback, options) {
            //初始化参数数据
            options = options ? options : {};
            //初始化POST数据
            options.data = options.data ? options.data : {};
            var opts = $.extend({
                type: 'image',
                extensions: 'gif,jpg,jpeg,png',
                multiple: false,
                data: {}
            }, options);
            require(['bootstrap', 'fileUploader'], function ($, fileUploader) {
                fileUploader.show(function (images) {
                    if (images.length > 0) {
                        if ($.isFunction(callback)) {
                            callback(images);
                        }
                    }
                }, opts);
            });
        },
        //上传文件
        file: function (callback, options) {
            //初始化参数数据
            options = options ? options : {};
            //初始化POST数据
            options.data = options.data ? options.data : {};
            var opts = $.extend({
                type: 'file',
                extensions: 'doc,ppt,wps,zip,txt',
                multiple: false,
                fileSizeLimit: 200 * 1024 * 1024,
                fileSingleSizeLimit: 5 * 1024 * 1024,
                data: ''
            }, options);
            require(['bootstrap', 'fileUploader'], function ($, fileUploader) {
                fileUploader.show(function (files) {
                    if (files) {
                        if ($.isFunction(callback)) {
                            callback(files);
                        }
                    }
                }, opts);
            });
        },
        //上传图片
        mobileImage: function (callback, options) {
            //初始化参数数据
            options = options ? options : {};
            //初始化POST数据
            options.data = options.data ? options.data : {};
            var opts = $.extend({
                type: 'mobileImage',
                extensions: 'gif,jpg,jpeg,bmp,png',
                multiple: false,
            }, options);
            require(['bootstrap', 'fileUploader'], function ($, fileUploader) {
                fileUploader.show(function (images) {
                    if (images) {
                        if ($.isFunction(callback)) {
                            callback(images);
                        }
                    }
                }, opts);
            });
        },

        //常用正则验证
        reg: function (val, type) {
            switch (type) {
                case 'email':
                    return /^([a-zA-Z0-9_\-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/i.test(val);
                case 'http':
                    return /^(http[s]?:)?(\/{2})?([a-z0-9]+\.)?[a-z0-9]+(\.(com|cn|cc|org|net|com.cn))$/i.test(val);
                case 'tel':
                    return /(?:\(\d{3,4}\)|\d{3,4}-?)\d{8}/.test(val);
                case 'phone':
                    return /^\d{11}$/.test(val);
                case 'identity':
                    return /^(\d{15}|\d{18})$/.test(val);
            }
        },
        /**
         * 日期选择器
         * @param elem
         * {year:年元素,month:月元素,day:日元素},
         * @param val
         * {year:年值,month:月默认值,day:日默认值} 不传值也可以
         */
        date_picker: function (elem, val) {
            val = val ? val : {};
            require(['moment'], function (moment) {
                $(elem.year).append("<option value=''>年</option>");
                for (var i = 2016; i >= 1915; i--) {
                    $(elem.year).append("<option value='" + i + "'>" + i + "</option>");
                }
                //处理年
                if (val.year > 0) {
                    $(elem.year).val(val.year);
                }
                readerMonth(elem, val);
                if (val.month > 0) {
                    $(elem.month).val(val.month);
                }
                $(elem.year).change(function () {
                    readerMonth(elem, val);
                })
                //渲染月
                function readerMonth(elem, val) {
                    elem.month.options.length = 0;
                    $(elem.month).append("<option value=''>月</option>");
                    for (var i = 1; i <= 12; i++) {
                        $(elem.month).append("<option value='" + i + "'>" + i + "</option>");
                    }
                    if (val.day > 0) {
                        $(elem.day).val(val.day);
                    }
                    readerDay(elem, val);
                    $(elem.month).change(function () {
                        readerDay(elem, val);
                    })
                }

                //渲染日
                function readerDay(elem, val) {
                    if (elem.day) {
                        var dayNum = moment($(elem.year).val() + "-" + $(elem.month).val(), "YYYY-MM").daysInMonth();
                        elem.day.options.length = 0;
                        $(elem.day).append("<option value=''>日</option>");
                        for (var i = 1; i <= dayNum; i++) {
                            elem.day.options.add(new Option(i, i));
                        }
                        if (val.day > 0) {
                            $(elem.day).val(val.day);
                        }
                    }
                }
            });
        },
        /**
         * 预览图片
         * @param url 图片URL地址
         */
        preview: function (url) {
            require(['util'], function (util) {
                util.modal({
                    title: '图片预览',
                    width: 700,
                    height: 500,
                    content: '<div style="text-align: center"><img style="max-width: 650px;max-height: 500px;" src="' + url + '"/></div>'
                })
            })
        },
        //发送短信或邮箱验证码
        validCode: function (option) {
            require(['jquery', 'util'], function ($, util) {
                //上次发送的时间
                var obj = {
                    //按钮
                    el: '',
                    //验证码等待发送时间
                    timeout: 0,
                    //定时器编号
                    intervalId: 0,
                    //初始化
                    init: function () {
                        var This = this;
                        this.el = $(option.el);
                        this.el.on('click', function () {
                            This.send();
                        })
                        this.timeout = option.timeout * 1;
                        this.update();
                    },
                    //更改状态
                    update: function () {
                        var This = this;
                        This.intervalId = setInterval(function () {
                            if (This.timeout > 0) {
                                This.el.text(--This.timeout + "秒后再发送")
                                    .attr('disabled', 'disabled');
                            } else {
                                clearInterval(This.intervalId);
                                This.el.removeAttr('disabled').text('发送验证码');
                            }
                        }, 1000);
                    },
                    //发送验证码
                    send: function () {
                        var This = this;
                        var username = $.trim($(option.input).val());
                        if (!/^\d{11}$/.test(username) && !/^.+@.+$/.test(username)) {
                            util.message('帐号格式错误', '', 'info');
                            return;
                        }
                        $.post(option.url, {username: username}, function (response) {
                            util.message(response.message);
                            This.timeout = response.timeout;
                            This.update();
                        }, 'json');
                    }
                }
                obj.init();
            })
        },
        //百度地图
        map: function (val, callback) {
            require(['map', 'util'], function (BMap, util) {
                if (!val) {
                    val = {};
                }
                if (!val.lng) {
                    val.lng = 116.403851;
                }
                if (!val.lat) {
                    val.lat = 39.915177;
                }
                var point = new BMap.Point(val.lng, val.lat);
                var geo = new BMap.Geocoder();

                var modalobj = $('#map-dialog');
                if (modalobj.length == 0) {
                    var content =
                        '<style>.tangram-suggestion-main { z-index : 9999; }/*搜索样式*/</style>' +
                        '<div class="form-group">' +
                        '<div class="input-group">' +
                        '<input type="text" class="form-control" id="suggestId" placeholder="请输入地址来直接查找相关位置">' +
                        '<input type="text" id="coordinate" class="form-control" style="display: none;">' +
                        '<div id="searchResultPanel" style="border:1px solid #c0c0c0;width:150px;height:auto; display:none;z-index:2000"></div>' +
                        '<div class="input-group-btn">' +
                        '<button class="btn btn-default"><i class="icon-search"></i> 搜索</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div id="map-container" style="height:400px;"></div>';
                    var footer =
                        '<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>' +
                        '<button type="button" class="btn btn-primary">确认</button>';
                    modalobj = util.modal({
                        title: '请选择地点',
                        content: content,
                        footer: footer,
                        id: 'map-dialog'
                    });
                    modalobj.find('.modal-dialog').css('width', '80%');
                    modalobj.modal({'keyboard': false});

                    map = util.map.instance = new BMap.Map('map-container');
                    map.centerAndZoom(point, 12);
                    map.enableScrollWheelZoom();
                    map.enableDragging();
                    map.enableContinuousZoom();
                    map.addControl(new BMap.NavigationControl());
                    map.addControl(new BMap.OverviewMapControl());
                    marker = util.map.marker = new BMap.Marker(point);
                    marker.setLabel(new BMap.Label('可移动标记设置坐标', {'offset': new BMap.Size(10, -20)}));
                    map.addOverlay(marker);
                    marker.enableDragging();

                    marker.addEventListener('dragend', function (e) {
                        var point = marker.getPosition();
                        geo.getLocation(point, function (address) {
                            modalobj.find('#suggestId').val(address.address);
                            modalobj.find('#coordinate').val(e.point.lng + "," + e.point.lat);
                        });
                    });

                    function searchAddress(address) {
                        geo.getPoint(address, function (point) {
                            map.panTo(point);
                            marker.setPosition(point);
                            marker.setAnimation(BMAP_ANIMATION_BOUNCE);
                            setTimeout(function () {
                                marker.setAnimation(null)
                            }, 3600);
                        });
                    }

                    modalobj.find('.input-group :text').keydown(function (e) {
                        if (e.keyCode == 13) {
                            var kw = $(this).val();
                            searchAddress(kw);
                        }
                    });
                    modalobj.find('.input-group button').click(function () {
                        var kw = $(this).parent().prev().prev().prev().val();
                        searchAddress(kw);
                    });

                    //百度地图API功能
                    function G(id) {
                        return document.getElementById(id);
                    }

                    //建立一个自动完成的对象
                    var ac = new BMap.Autocomplete({
                        "input": "suggestId"
                        , "location": map
                    });

                    ac.addEventListener("onhighlight", function (e) {  //鼠标放在下拉列表上的事件
                        var str = "";
                        var _value = e.fromitem.value;
                        var value = "";
                        if (e.fromitem.index > -1) {
                            value = _value.province + _value.city + _value.district + _value.street + _value.business;
                        }
                        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

                        value = "";
                        if (e.toitem.index > -1) {
                            _value = e.toitem.value;
                            value = _value.province + _value.city + _value.district + _value.street + _value.business;
                        }
                        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
                        G("searchResultPanel").innerHTML = str;
                    });

                    var myValue;
                    ac.addEventListener("onconfirm", function (e) {
                        //鼠标点击下拉列表后的事件
                        var _value = e.item.value;
                        myValue = _value.province + _value.city + _value.district + _value.street + _value.business;
                        G("searchResultPanel").innerHTML = "onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
                        setPlace();
                    });

                    function setPlace() {
                        //map.clearOverlays();    //清除地图上所有覆盖物a
                        function myFun() {
                            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
                            var coordinate = pp.lng + "," + pp.lat;
                            modalobj.find('#coordinate').val(coordinate);
                        }

                        var local = new BMap.LocalSearch(map, { //智能搜索
                            onSearchComplete: myFun
                        });
                        local.search(myValue);
                    }

                }
                modalobj.off('shown.bs.modal');
                modalobj.on('shown.bs.modal', function () {
                    marker.setPosition(point);
                    map.panTo(marker.getPosition());
                });

                modalobj.find('button.btn-primary').off('click');
                modalobj.find('button.btn-primary').on('click', function () {
                    if ($.isFunction(callback)) {
                        var point = util.map.marker.getPosition();
                        geo.getLocation(point, function (address) {
                            var val = {lng: point.lng, lat: point.lat, address: address.address};
                            callback(val);
                        });
                    }
                    modalobj.modal('hide');
                });
                modalobj.modal('show');
            });
        }
    };
    if (typeof define === "function" && define.amd) {
        define(['bootstrap'], function () {
            return util;
        });
    } else {
        window.util = util;
    }
})(window);