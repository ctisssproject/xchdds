(function($){
	$.extend({
		showTip : function(content){
			var obj = $(content);
			obj.appendTo("body");
			var myleft=($("body").width()-obj.width())/2+$("body").attr("scrollLeft");
	  		var mytop=($("body").height()-obj.height())/3+$("body").attr("scrollTop");
			obj.css("left",myleft).css("top",mytop).fadeIn("slow");
			window.setTimeout(function(){obj.fadeOut(1000);},1000);
			window.setTimeout(function(){obj.remove();},2000);
		},
	
		tooltip : function(){			
			xOffset = 10;
			yOffset = 20;		
			$("[title!='']").each(function(){
				$(this).hover(
				function(e){											  
					this.t = this.title;
					this.title = "";									  
					$("body").append("<div id='tooltip'>"+ this.t +"</div>");
					$("#tooltip")
						.css("top",(e.pageY - xOffset) + "px")
						.css("left",(e.pageX + yOffset) + "px")
						.fadeIn("fast");		
	    			},
				function(){
					this.title = this.t;		
					$("#tooltip").remove();
	    		});	
				$(this).mousemove(function(e){
					$("#tooltip")
						.css("top",(e.pageY - xOffset) + "px")
						.css("left",(e.pageX + yOffset) + "px");
				});
	 		});			
		},
	
		tooltipForm : function(){			
			xOffset = 10;
			yOffset = 20;
			$("[name^='DATA_']").each(function(){
		  		//初始化title信息	
				$(this).hover(
				function(e){											  
					this.t = this.title;
					this.title = "";									  
					$("body").append("<p id='tooltip'>"+ td_lang.inc.msg_52+this.t+"&nbsp;&nbsp;"+td_lang.inc.msg_53+this.name.substr(5) +"</p>");
					$("#tooltip")
						.css("top",(e.pageY - xOffset) + "px")
						.css("left",(e.pageX + yOffset) + "px")
						.fadeIn("fast");		
	    		},
				function(){
					this.title = this.t;		
					$("#tooltip").remove();
	    		});
	  			$(this).mousemove(function(e){
					$("#tooltip")
						.css("top",(e.pageY - xOffset) + "px")
						.css("left",(e.pageX + yOffset) + "px");
				});		
	  		});		
		}
	});	
})(jQuery);