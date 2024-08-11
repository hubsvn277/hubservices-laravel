"use strict";

 $(window).on('load', function () {
	//------------------------------------------------------------------------
	//						PRELOADER SCRIPT
	//------------------------------------------------------------------------
	$("#preloader").delay(400).fadeOut("slow");
	$("#preloader .clock").fadeOut();
});

window.addEventListener('load', function() {


//start spr-countdown
var $popup_countdown_countdown = $('#popup-countdown-countdown');
$popup_countdown_countdown.countdown('2024/09/10 23:59:59', function (event) {
    $popup_countdown_countdown.find('.days').html(event.strftime('%D'));
    $popup_countdown_countdown.find('.hours').html(event.strftime('%H'));
    $popup_countdown_countdown.find('.minutes').html(event.strftime('%M'));
    $popup_countdown_countdown.find('.seconds').html(event.strftime('%S'));
}).on('finish.countdown', function () {

}//end finish.countdown
);//end spr-countdown
});
