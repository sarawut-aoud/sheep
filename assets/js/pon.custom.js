function commaSeparateNumber(val){
	nStr = val;
	nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}



RegExp.escape = function(text) {
  return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
};

function searchIndex( keywords, arr ){

	var keywords = keywords.split(" ");
	
	var answer = [];
	$.each(arr, function(index,value){
	var temp = value;
	var score = 0;
		$.each( keywords, function(i,keyword){
			// exact with id
			if( keyword.toUpperCase() == value.id.toUpperCase() ) score += 10;
			
			// exact with name
			if( keyword.toUpperCase() == value.name.toUpperCase() ) score += 10;
			
			// starter of each phrase
			var regex = new RegExp("\b"+RegExp.escape(keyword),"gi");
				score += 2;
				
				
			// number of repeat
			var regex = new RegExp(RegExp.escape(keyword),"gi");
				score += value.label.match(regex).length;		
		});
		//-- recored the score
		temp["score"] = score; answer.push(temp);
	});
	
	//-- rearrange
		arr = answer.sort(function(a,b) { return b["score"] - a["score"] } );
	return arr.slice(0, 9);;
}


function isJSON(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


function json_decode(text){
	try {
		var temp = JSON.parse(text.replace(/\\/g,''));
	}
	catch(err) {
		var temp = [];
		console.log(err);
	}
	return temp;
}


function popup(url,height,width){
var height 	= (height && height > 0)?height:570;
var width 	= (width && width > 0)?width:1024;
return window.open(url, '_blank', 'location=yes,height='+height+',width='+width+',scrollbars=yes,status=yes');	
}




function popupCenter(url, h, w) {
var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

var h 	= (h && h > 0)?h:570;
var w 	= (w && w > 0)?w:1024;

var systemZoom = width / window.screen.availWidth;
var left = (width - w) / 2 / systemZoom + dualScreenLeft
var top = (height - h) / 2 / systemZoom + dualScreenTop
var newWindow = window.open(url, "_blank", 'scrollbars=yes, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);

if (window.focus) newWindow.focus();
return newWindow;
}


Number.prototype.eRound = function(decimals) { 
var y = this*1;
	y = (Math.abs(y) > 0.000000001)?y:0;
	if( decimals === 0 ){
		decimals = 0;
	}else{
		decimals = (decimals)?decimals:2;
	}
var d = decimals*1+8;
	d = (d > 12)?12:d;
	y = Number(Math.round((y).toFixed(d)+'e'+d)+'e-'+d).toFixed(d);
	return Number(Math.round((y+"").replace(/[^0-9.-]/g,'')+'e'+decimals)+'e-'+decimals).toFixed(decimals); 
};

String.prototype.eRound = function(decimals) { 
var y = this*1;
	y = (Math.abs(y) > 0.000000001)?y:0;
	if( decimals === 0 ){
		decimals = 0;
	}else{
		decimals = (decimals)?decimals:2;
	}
var d = decimals*1+8;
	d = (d > 12)?12:d;
	y = Number(Math.round((y+"").replace(/[^0-9.-]/g,'')+'e'+d)+'e-'+d).toFixed(d); 
	return Number(Math.round((y+"").replace(/[^0-9.-]/g,'')+'e'+decimals)+'e-'+decimals).toFixed(decimals); 
};
