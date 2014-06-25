// JavaScript Document
var cate_step = 1;

$(function(){
	$(".rs_jq_timer").each(function(){
		countDown($(this).html(), this);
	});
});
function countDown(time, elemId){
	//if(typeof end_time == "string")
	var end_time = new Date(time).getTime();//月份是实际月份-1
	//current_time = new Date().getTime(),
	var sys_second = (end_time-new Date().getTime())/1000;
	var timer = setInterval(
		function(){
			var elemText = "剩余";
			if (sys_second > 0) {
				sys_second -= 1;
				var day = Math.floor((sys_second / 3600) / 24);
				var hour = Math.floor((sys_second / 3600) % 24);
				var minute = Math.floor((sys_second / 60) % 60);
				var second = Math.floor(sys_second % 60);
				if(day > 0){
					elemText += "<b>" + day + "</b>天";
				}
				elemText += "<b>" + hour + "</b>时";
				elemText += '<b>' + minute + "</b>分";
				elemText += '<b>' + second + "</b>秒";
				$(elemId).html(elemText);
			} else { 
				clearInterval(timer);
				$(elemId).text("活动结束");
			}
		}, 1000);
}