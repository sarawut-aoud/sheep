function date2slash(date){
var d = date;
	if(d){	d = d.split("-"); d = d[2]+"/"+d[1]+"/"+d[0]; }
	else { d = ""; }
	return d;
}

function date2dash(date){
var d = date;
	if(d){	d = d.split("/"); d = d[2]+"-"+d[1]+"-"+d[0]; }
	else { d = ""; }
	return d;
}


function toastr_call(text,type,time,title){

var timeOut = 1000;
	if(time){
		timeOut = time;
	}

	
	if(title){
		//do nothing
	}else{
		title = "PROCESSING";
	}
		
	$.gritter.add({
		// (string | mandatory) the heading of the notification
		title: ""+title,
		// (string | mandatory) the text inside the notification
		text: ""+text,
		// (string | optional) the image to display on the left
		// (bool | optional) if you want it to fade out on its own or just sit there
		sticky: false,
		// (int | optional) the time you want it to be alive for before fading out
		time: timeOut,
	});	

}



// disable scroll menu
function disable_scroll()
{
    var scrollX = window.scrollX, scrollY = window.scrollY;
	window.onscroll = function(e){
		scroll(scrollX,scrollY);
	}
}

function enable_scroll()
{
	window.onscroll = "";
}

$(".stopScroll").on("mouseover",function(){
	disable_scroll();
});
$(".stopScroll").on("mouseleave",function(){
	enable_scroll();
});

// end disable scroll menu



/*
*	form2json
*	turn form to json (that is in particular form)
*/
	$.fn.form2json = function ()
	{
		
		var y = $(this).find("input, textarea");
		var json = {};
		
		
		
		$.each(y, function(){
							
			json[$(this).attr("name")] = $(this).val();
		});

		return json;
	}
	

	
/*
*	text2editable 
*	turn class text2input to input and text2textarea to textarea (that is in particular form)
*
*	output class -> editable
*/ 
	$.fn.text2editable = function ()
	{
		
		
		var main = $(this);
		var original = main.html();
		
		
	
		var y = $(this).find(".text2input, .text2textarea, .text2select");
		
		$.each(y, function(){
			
			var temp = "";
			
			if( $(this).hasClass("text2input") )
			{
				temp = 	"<input type='text' class='editable' name='" + $(this).attr('name') + "' " +
						"value='" + $(this).text() + "' original='" + $(this).text() + "'"+
						">";
						
				$(this).html(temp);
			}
			else if( $(this).hasClass("text2textarea") )
			{
				temp = 	"<textarea class='editable' name='" + $(this).attr('name') + "'" +
						"original='" + $(this).text() + "'>"+
						$(this).text() +
						"</textarea>";
						
				$(this).html(temp);
			}
			else if( $(this).hasClass("text2select") )
			{
			
			var text 	= $(this).text();
			var options = $(this).attr('options').split(" ");
				
				temp = 	"<select class='editable' name='" + $(this).attr('name') + "'>";
							
					$.each(options, function(i){
						
						if( text.toLowerCase() == options[i].toLowerCase() )
						{
							temp += "<option selected>" + options[i] + "</option>";
						}
						else
						{
							temp += "<option>" + options[i] + "</option>";
						}
						
					});
				
				temp += "</select>";
						
				$(this).html(temp);
			}
		});
	
		
		
	//-- add hidden
		var hidden = "";
		if( main.is("tbody") )
		{
			hidden = 	"<table class='original' style='display:none;'>" +
							"<tbody name='original'>" +
								original +
							"</tbody>" +
						"</table>";
		}
		else if ( main.is("tr") )
		{
			hidden = 	"<table class='original' style='display:none;'>" +
							"<tbody>" +
								"<tr name='original'>" + original + "</tr>" +
							"</tbody>" +
						"</table>";
		}
		else
		{
			hidden = 	"<div name='original' style='display:none;'>" +
							original +
						"</div>";
		}
		
		main.append(hidden);
		
	}

	
/*
*	editable2text
*	turn class editable to text
*
*	output class -> text2textarea or text2input
*/ 
	$.fn.editable2text = function ()
	{
		//-- remove original
		var t = $(this).find("[name=original]");
		if( t.is("tbody") )
		{
			t.parents("table.original").remove();
		}
		else
		{
			t.remove();
		}
		
		
		var y = $(this).find(".editable");
		
		
		$.each(y, function(){
			
			var temp = $(this).val();

				$(this).replaceWith(temp);
		});
		
		
	}

	
/*
*	editable2text
*	turn class editable to text
*
*	output class -> text2textarea or text2input
*/ 
	$.fn.editable2original = function ()
	{
		
		var y = $(this).find("[name=original]").html();
		
		//-- replace with original
		$(this).html(y);
	}

