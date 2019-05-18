/**
 * Created by zcy on 2016/11/3 0003.
 */
//zwardList
//抽奖的数组   titile中文名称  url 图片路径  type 是否是奖
var newArr=[
    {title:"亞菲兒香水",url:"zWardS_gift1.png",type:"yes"},
    {title:"Gucci帽子",url:"zWardS_gift2.png",type:"yes"},
    {title:"再接再厉哦",url:"zWardS_fail1.png",type:"no"},
    {title:"华为p20",url:"zWardS_gift3.png",type:"yes"},
    {title:"5元话费",url:"zWardS_gift4.png",type:"yes"},
    {title:"飞利浦剃须刀",url:"zWardS_gift5.png",type:"yes"},
    {title:"明日再战",url:"zWardS_fail2.png",type:"no"},
    {title:"短柄伞",url:"zWardS_gift6.png",type:"yes"}	
];
$(function(){
//初始化样式 宽度
var w=$("#zWardcontainer").width()/3;
var padW=parseInt(0.03*w);
var innerW=w-padW*2;
console.log(w+":"+padW+":"+innerW)
$("#zWardcontainer").luckDraw({
cwidth:w, //宽
cheight:w,
padc:padW,
Arrays:newArr,
times:3,   //次数  抽奖次数  积分/20
 show:true,  
})
})
var arr=[
    {title:"耳机一副",url:"1.png"},
    {title:"ipad",url:"2.png"},
    {title:"谢谢参与",url:"3.png"},
    {title:"谢谢参与",url:"3.png"},
    {title:"谢谢参与",url:"3.png"},
    {title:"蓝色运动鞋",url:"4.png"},
    {title:"红色运动鞋",url:"5.png"},
    {title:"洋娃娃",url:"6.png"},
    {title:"小米",url:"7.png"},
    {title:"苹果",url:"8.png"}
];
$.fn.extend({     
luckDraw:function(opt){
var defaults={
    cwidth:100, //宽
    cheight:100,//高
    cline:3,    //行数
    clist:3,    //列数
    padc:3,     //间距
    times:2,    //次数
    show:false,   //是否显示选中号码
    Arrays:arr
};
var options=$.extend({},defaults,opt) ; //参数扩展
var parentElement = $(this).find("ul"); //祖父元素
var cline=options.cline;//行数
var clist=options.clist;//列数
var cWidth=options.cwidth;//宽
var cHeight=options.cheight;//高
var clickBtn=options.clickObj;//点击对象
var showT=options.show;
var pad=options.padc;
var allTime=options.times;
var clickBtn=$("<div class='begin bor7'>开始</div>"); //开始按钮
var randomE=$("<div class='randomE bor7'>未开始</div>")
var result=$("<div class='result bor7'>结果：<span></span></div>");
var number=$("<div class='numCount'><p>您共有：<span id='timesWard'>"+allTime+"</span>次机会</p></div>");
$(this).find(".top").before(number);
$(this).find(".top").append(clickBtn);
if(showT){  //可查看结果
    $("body").append(result);
}
var all=cline*clist-(cline-2)*(clist-2);//子对象个数
//图片数组
var urldata="images/";
var arr=options.Arrays;
var newA=[];
var arrsNum=[];
function createRandom(){
    newA=[];
    for(var i=0;i<arr.length;i++){
          newA.push(i);
    }

    //重新获取不设奖项的数组
    arrsNum=[];
    for(var i=0;i<newA.length;i++){
        var indexa=newA[i];
        var titles=arr[indexa].title;
        if(titles=="谢谢参与"){
            arrsNum.push(i);
        }
    }

}

function getIndexs(txt){
   var indexs="";
   for(var i=0;i<newA.length;i++){
       var indexa=newA[i];
       var titles=arr[indexa].title;
       if(titles==txt){
           indexs=i;
       }
   }
   return indexs;
}

//生成子元素 以及 初始化定位
function newLI(){
   createRandom()
   //获得不设置奖项的位数；

   parentElement.html('');
   for(var i=0;i<all;i++){
       var indexa=newA[i];
       var titles=arr[indexa].title;
       var imgs=urldata+arr[indexa].url;
       if(i%2==0){
          var liElement=$("<li class='box_S odd'><div class='inner bor3 box_S'><span> "+titles+"</span><img src='"+imgs+"'/></div></li>");
       }else{
          var liElement=$("<li class='box_S even'><div class='inner bor3 box_S'><span> "+titles+"</span><img src='"+imgs+"'/></div></li>");
       }
       parentElement.append(liElement);
   }
}
newLI();
var childElement=parentElement.find("li");
childElement.css({"width":cWidth+"px","height":cHeight+"px","line-height":cHeight+"px"});
parentElement.css({"width":cWidth*clist+"px","height":cHeight*cline+"px"})
//$(this).css({"width":cWidth*clist+"px","height":cHeight*cline+"px","position":"relative"})

var clickW=(clist-2)*cWidth;
var clickH=(cline-2)*cHeight;
var oddw=(clist-2)*2*pad;
var oddh=(cline-2)*2*pad;
childElement.find(".inner").css({"width":cWidth-pad*2,"height":cHeight-pad*2,"margin":pad});
clickBtn.css({"width":clickW-2*pad+"px","height":clickH-2*pad+"px","line-height":clickH+"px","position":"absolute","left":"50%",
    "margin-left":-(clickW-2*pad)/2+"px","top":"50%","margin-top":-(clickH-2*pad)/2+"px"})
childElement.each(function(index){
    var indexs=index;

    if(indexs<clist){
        var leftd=indexs%clist*cWidth;
        $(this).css({"left":leftd+"px","top":"0px"})//,"border-left":"0"
        if(indexs==0){
            $(this).css({"border-bottom":"0"});
        }
    }else if(indexs>=clist&&indexs<(cline+clist-1)){
        var topc=(indexs+1)%clist*cHeight;
        $(this).css({"right":"0px","top":topc+"px"})//,"border-top":"0"
    }else if(indexs>=(cline+clist-1)&&index<(all-(cline-2))){ //下面一行
        var rightC=(indexs-(cline+clist-2))*cWidth;
        $(this).css({"bottom":"0","right":rightC+"px"});//,"border-right":"0"
    }else{
        var bottomC=(indexs-(all-(cline-1)))*cHeight;
        $(this).css({"left":"0","bottom":bottomC+"px"});//,"border-bottom":"0"
    }
})
//重新排序li里面的内容
function renewLI(){
    createRandom();
    parentElement.find("li").each(function(i){
        var indexa=newA[i];
        var titles=arr[indexa].title;
        var imgs=urldata+arr[indexa].url;
        $(this).find(".inner").html("<span>"+titles+"</span><img src='"+imgs+"'/>")
    })
}
//
var ix = 0;
var speed =all*10;
var Countdown = all*100; //倒计时
var isRun = false;
var dgTime = 0;
var speedN=150;
clickBtn.click(function(){
   // childElement.eq(ex).addClass("cur");
    randomE.html("未开始");
    result.html("结果:");
    if(isRun){
        if(allTime<=0){ //积分已经用完了
           $.DialogByZ.Alert({Title: "提示", Content: "您当前抽奖次数已用完！",BtnL:"知道了"});
         }
        return;
    }else{
        //重新生成序列
        //renewLI();
        console.log(all);
        var stime = Math.floor(Math.random()*all+1);   //为中奖的序号    1-8 
       //stime =getIndexs("谢谢参与")+parseInt(1);

       // stime=1;  可以直接指定中间的号码
       console.log("中奖数字为：" +stime)
        dgTime += stime*10+speedN;
        speedUp();
    }
})
function speedUp(){ //加速
    isRun = true;
    childElement.removeClass("cur");
    childElement.eq(ix).addClass("cur");
    ix++;
    init(ix);
    speed -=10;
    if(speed ==0){
        clearTimeout(stop);
        speed=speedN;
        uniform();
    }else{
        var stop = setTimeout(speedUp,speed);
    }
}
function uniform(){ //匀速
    childElement.removeClass("cur");
    childElement.eq(ix).addClass("cur");
    ix++;
    init(ix);
    Countdown -= 50 ;
    if(Countdown == 0){
        clearTimeout(stop);
        speedDown();

    }else{
        var stop = setTimeout(uniform,speed);
    }
}
function speedDown(){ //减速
    childElement.removeClass("cur");
    childElement.eq(ix).addClass("cur");
    ix++;
    init(ix);
    speed += 10;
    if(speed == dgTime){
        clearTimeout(stop);
        end();
    }else{
        var stop = setTimeout(speedDown,speed);
    }
}
function end(){
    if(ix == 0){
        ix = all;
    }
    if(showT) {
        ///result.html('结果：恭喜 <span> ' + ix + ' </span> 号中奖');  ///可注释掉
        var indexs=newA[ix-1];
        //结果
        setTimeout(function(){
            drawArd(indexs,allTime);
            initB();  	
        },500)
        
        if(arr[indexs].title=="谢谢参与"){
            result.html('<span>' + arr[indexs].title + ' </span>');  ///可注释掉
        }else{
            result.html('结果：恭喜您获得<span>' + arr[indexs].title + ' </span>');  ///可注释掉
        }
    }
    
}
///--归0
function init(o){
    if(o == all){
        ix = 0;
    }
}
///
function initB(){
    ix = 0;
    speed =all*50;
    Countdown = all*100; //倒计时
    isRun = false;
    dgTime = 0;
    allTime--;
    //number.html("");
    number.html("<p>您还有：<span id='timesWard'>"+allTime+"</span>次机会</p>");
    if(allTime<=0){
        isRun =true;
        number.html("<p>您的次数已经用完啦！</p>")
     
        
    }

}
}
})
//弹出层 参数
// 关闭按钮 

$(function(){
  $(".lotteryBtn").click(function(){
      $(this).parents(".lotteryDialogs").hide();
      $(".bgfix").hide();
      
      return false;
  })
})
function drawArd(datas,times){
    datas=parseInt(datas);  
    var type=newArr[datas].type;
    var txts=newArr[datas].title;
    if(type=='no'){
        $(".lotteryDinner").html("<div class='wbox wardFail box_S'><p>重要的是开心喽</p></div>")
    }else{
       $(".lotteryDinner").html("<div class='wbox wardSucess box_S'><p>获得"+txts+"</p></div>") 
    }
    if(times==1){
        $(".lotteryBtn").text("再抽一次");
    }else{
       $(".lotteryBtn").text("再抽一次");
    }
    var wparent=parseInt($(".innerTweBottom").width());
    if(wparent>430){
        wparent=430;
    }
    var wsw=parseInt(0.8*wparent);
    var wsh=wsw*297/434;
    var wsp=wsh*0.6;
    $(".wbox").css({"height":wsh+"px","padding-top":wsp+"px"})
    $(".lotteryDialogs,.bgfix").show();
}