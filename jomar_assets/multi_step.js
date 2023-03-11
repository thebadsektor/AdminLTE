    
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
$("#fs1_btn").click(function () {
// $(".next").click(function () {
			
	// FIELDSET 1 ERROR TRACING
		var fs1error_counter = 0;
		$(".fsv_1").each(function () {
			if($(this).val() == "") {
				$(this).css("border","1px solid red");
				fs1error_counter++;	
			} else {
				$(this).css("border","1px solid #ccc");
			}
		});
	if(fs1error_counter == 0){
		if(animating) return false;
		animating = true;
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		//show the next fieldset
		next_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({
			'transform': 'scale('+scale+')',
			'position': 'absolute'
		});
				next_fs.css({'left': left, 'opacity': opacity});
			}, 
			duration: 600, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
			// end ng if trace erro
	}else{
		myalert_danger_af("Please Fillup required inputs!","nothing");
	}
});

$("#fs2_btn").click(function () {
// $(".next").click(function () {
			
	// FIELDSET 2 ERROR TRACING
	var fs2error_counter = 0;
		$(".fsv_2").each(function () {
			if($(this).val() == 0) {
				$(this).css("border","1px solid red");
				fs2error_counter++;	
			} else {
				$(this).css("border","1px solid #ccc");
			}
		});
	if(fs2error_counter == 0){
		if(animating) return false;
		animating = true;
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		//show the next fieldset
		next_fs.show(); 
		//hide the current fieldset with style
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				current_fs.css({
			'transform': 'scale('+scale+')',
			'position': 'absolute'
		});
				next_fs.css({'left': left, 'opacity': opacity});
			}, 
			duration: 600, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
			// end ng if trace erro
	}else{
		myalert_danger_af("Please Fillup required inputs!","nothing");
	}
});

$("#fs3_btn").click(function () {
// $(".next").click(function () {
			
	// FIELDSET 2 ERROR TRACING
	var fs3error_counter = 0;
		$("input.fsv_3").each(function () {
			if($(this).val() == 0) {
				$(this).css("border","1px solid red");
				fs3error_counter++;	
			} else {
				$(this).css("border","1px solid #ccc");
			}
		});
		$("select.fsv_3").each(function () {
			if($(this).val() == 0) {
				$(this).css("border", "1px solid red");
				$(this).parent().find("button").css("border", "1px solid red");
				fs3error_counter++;	
			} else {
				$(this).css("border", "1px solid #ccc");
				$(this).parent().find("button").css("border", "1px solid #ccc");
			}
		});
	if (fs3error_counter == 0){
		$(this).prop("disabled",true);
		// submit the form
		var serializeData = $("#msform").serialize();
		$.ajax({
			type: "POST",
			url: "mswd/mswd_form_saving.php",
			data: { serializeData: serializeData },
			success: function (result) {
				if(result == 0) {
					myalert_success_af("Data Successfully inserted!","mswdmodule.php?dir=entries");
				} else {
					myalert_danger_af("Failed to insert!","nothing");
				}
			}
		});
	}else{
		myalert_danger_af("Please Fillup required inputs!","nothing");
	}
});
$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 600, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function () {
	return false;
});