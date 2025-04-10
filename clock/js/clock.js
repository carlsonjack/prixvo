'use strict';
const { useState } = React;
function convertDateToAnotherTimeZone(date, timezone) {
	const dateString = date.toLocaleString('en-US', {
		timeZone: timezone
	});
	return new Date(dateString);
}
function getKeyByValue(object, value) {
	var isfind = 0;
	for (var prop in object) {
		if (object.hasOwnProperty(prop)) {
			if (object[prop] === value)
				isfind = prop;
		}
	}
	return isfind;
}
/* this function is used to prevent module call if expired or run ajax call is not expired*/
function callAjax(element, check = false) {
	if (check) {
		return element.hasAttribute("hasExpiredAuction");
	} else {
		if (!element.hasAttribute("hasExpiredAuction")) {
			element.setAttribute("hasExpiredAuction", "yes");
			UatCheckExpired(element);
		}
	}
}
/* this function is used to call ajax on expire auction*/
function UatCheckExpired(element) {
	UAT_Ajax_Url = UATAUCTION.ajaxurl;
	element = jQuery(element);
	/* Ajax query String */
	Ajax_qry_str = Uat_Ajax_Qry.ajaxqry;
	Uat_last_activity = UATAUCTION.last_timesta
	var auctionid = element.data('auction-id');
	var uwa_container = element.parent().next('.uwa_auction_product_ajax_change');
	uwa_container.empty().prepend('<div class="ajax-loading"></div>');
	uwa_container.parent().children('form.buy-now').remove();
	var scheduled = element.hasClass('scheduled') ? 'true' : 'false';
	var ajaxurl = Ajax_qry_str + '=expired_auction';
	if (!auctionid) return;
	jQuery.ajax({
		type: "post",
		url: ajaxurl,
		cache: false,
		data: {
			action: "expired_auction",
			post_id: auctionid,
			ret: '1',
			scheduled: scheduled,
		},
		success: function (response) {
			if (response.length != 0) {
				uwa_container.children('.ajax-loading').remove();
				uwa_container.prepend(response);
				jQuery(".product-d-timer .closes-text").css("display", "none");
				element.html("<div>" + frontend_react_object.expired + "<div class='expire-win'>" + response + "</div></div>");
			}
		},
		async: false
	});
}
function Countdownapp(props) {
	var day = 0;
	var hours = 0;
	var minute = 0;
	var sec = 0;
	day = props.days;
	hours = props.hours;
	minute = props.minute;
	sec = props.sec;
	const [auctionEndTime, setAuctionEndTime] = useState(props.time);
	var clocksync = 0;
	var callback_fun = setInterval(function () {
		sec--;
		var ttt_ = getCookie("acution_end_time_php_" + props.auctionId);
		var getattr_time = get_data_attr_clock(props.element, 'data-time');
		if (ttt_ != null && getattr_time != ttt_) {
			tabfocused = 1;
			update_data_attr_clock(props.element, 'data-time', ttt_);
		}
		if (jQuery(props.element).hasClass('uwa-main-auction-product-loop')) {
		} else {
			if (tabfocused == 1) {
				setTimeout(function () {
					var setauctionId = props.auctionId;
					get_auction_sync_time(setauctionId);
					var get_syncjson = getCookie("acution_sync_time_" + props.auctionId);
					var get_syncjson_val = JSON.parse(get_syncjson);
					if (get_syncjson_val != null) {
						day = get_syncjson_val.days;
						hours = get_syncjson_val.hours;
						minute = get_syncjson_val.minute;
						sec = get_syncjson_val.sec;
					}
					tabfocused = 0;
				}, 2000);
			}
		}
		var isinloop = 0;
		if (jQuery(props.element).hasClass('uwa-main-auction-product-loop')) {
			if (multi_lang_data.settings.listpage == 'yes') {
				isinloop = 1;
				clocksync++;
				if (clocksync == 5) {
					var setauctionId = props.auctionId;
					get_auction_sync_time(setauctionId);
					var get_syncjson = getCookie("acution_sync_time_" + props.auctionId);
					var get_syncjson_val = JSON.parse(get_syncjson);
					if (get_syncjson_val != null) {
						day = get_syncjson_val.days;
						hours = get_syncjson_val.hours;
						minute = get_syncjson_val.minute;
						sec = get_syncjson_val.sec;
						update_data_attr_clock(props.element, 'data-time', ttt_);
					}
				}
			}
		} else {
			clocksync++;
			if (clocksync == 5) {
				var setauctionId = props.auctionId;
				get_auction_sync_time(setauctionId);
				var get_syncjson = getCookie("acution_sync_time_" + props.auctionId);;
				var get_syncjson_val = JSON.parse(get_syncjson);
				if (get_syncjson_val != null) {
					day = get_syncjson_val.days;
					hours = get_syncjson_val.hours;
					minute = get_syncjson_val.minute;
					sec = get_syncjson_val.sec;
					update_data_attr_clock(props.element, 'data-time', ttt_);
				}
			}
		}
		if (sec == 0) {
			if (day == 0 && hours == 0 && minute == 0) {
				sec = 0;
			} else {
				sec = 60;
			}
			minute--;
			if (minute < 0) {
				minute = 0;
			}
			if (minute == 0) {
				hours--;
				if (hours < 0) {
					hours = 0;
				} else {
					minute = 59;
				}
				if (hours == 0) {
					day--;
					if (day < 0) {
						day = 0
					} else {
						hours = 23;
					}
				}
			}
		}
		if (sec < 0) {
			sec = 0;
			clearInterval(callback_fun);
		}
		day = parseInt(day, 10);
		hours = parseInt(hours, 10);
		minute = parseInt(minute, 10);
		sec = parseInt(sec, 10);
		var html = "";
		if (multi_lang_data.settings.single_product_page) {
			// product single page
			if (day > 0) {
				html += day + "d " + hours + "h " + minute + "m " + sec + "s ";
			} else if (hours > 0) {
				html += hours + "h " + minute + "m " + sec + "s ";
			} else if (minute > 0) {
				html += minute + "m " + sec + "s ";
			} else {
				html += sec + "s ";
			}
		} else {

			// frontend_react_object.timer_day
			// frontend_react_object.timer_days
			// product list page 
			if (day > 0) {
				html += day + " " + (day > 1 ? frontend_react_object.timer_days : frontend_react_object.timer_day);
			} else if (hours > 0) {
				html += hours + "h " + minute + "m " + sec + "s ";
			} else if (minute > 0) {
				html += minute + "m " + sec + "s ";
			} else {
				html += sec + "s ";
			}
		}
		if (day == 0 && hours == 0 && minute == 0 && sec == 0) {
			props.element.innerHTML = html;
			var cltemp = setTimeout(function () { callAjax(props.element); clearInterval(cltemp); }, 1000);
		} else {
			props.element.innerHTML = html;
		}
	}, 1000);
	return "";
}
function Countdownapp_event(props) {
	var day = 0;
	var hours = 0;
	var minute = 0;
	var sec = 0;
	day = props.days;
	hours = props.hours;
	minute = props.minute;
	sec = props.sec;
	if (!props.event_id) {
		return;
	}
	var callback_fun_event = setInterval(function () {
		sec--;
		if (sec == 0) {
			if (day == 0 && hours == 0 && minute == 0) {
				sec = 0;
			} else {
				sec = 60;
			}
			minute--;
			if (minute < 0) {
				minute = 0;
			}
			if (minute == 0) {
				hours--;
				if (hours < 0) {
					hours = 0;
				} else {
					minute = 59;
				}
				if (hours == 0) {
					day--;
					if (day < 0) {
						day = 0
					} else {
						hours = 23;
					}
				}
			}
		}
		if (sec < 0) {
			sec = 0;
			clearInterval(callback_fun_event);
			jQuery.ajax({
				type: "post",
				url: ajaxurl,
				cache: false,
				data: {
					action: "uwa_event_expired",
					eventid: props.event_id,
				},
				success: function (response) {
					if (response) {
						if (response.status == 'success') {

						} else {
							location.reload();
						}
					}
				},
				error: function () {
					location.reload();
				},
			});
		}
		day = parseInt(day, 10);
		hours = parseInt(hours, 10);
		minute = parseInt(minute, 10);
		sec = parseInt(sec, 10);
		var html = "";
		if (multi_lang_data.settings.single_product_page) {
			// product single page
			if (day > 0) {
				html += day + "d " + hours + "h " + minute + "m " + sec + "s ";
			} else if (hours > 0) {
				html += hours + "h " + minute + "m " + sec + "s ";
			} else if (minute > 0) {
				html += minute + "m " + sec + "s ";
			} else {
				html += sec + "s ";
			}
		} else {
			// product list page 
			if (day > 0) {
				html += day + " " + (day > 1 ? frontend_react_object.timer_days : frontend_react_object.timer_day);
			} else if (hours > 0) {
				html += hours + "h " + minute + "m " + sec + "s ";
			} else if (minute > 0) {
				html += minute + "m " + sec + "s ";
			} else {
				html += sec + "s ";
			}
		}
		props.element.innerHTML = html;
	}, 1000);
	return "";
}
function intclock() {
	const ell = document.getElementsByClassName('auction-countdown-check');
	if (ell.length > 0) {
		for (var i = 0; i < ell.length; i++) {
			var elele = <Countdownapp days={ell[i].getAttribute('data-days')} hours={ell[i].getAttribute('data-hours')} minute={ell[i].getAttribute('data-minute')} sec={ell[i].getAttribute('data-sec')} time={ell[i].getAttribute('data-time')} zone={ell[i].getAttribute('data-zone')} auctionId={ell[i].getAttribute('data-auction-id')} isExpired={ell[i].querySelector("div > span.expired") ? "yes" : "no"} element={ell[i]} hasExpiredAuction={ell[i].getAttribute('hasExpiredAuction')} />;
			ReactDOM.render(elele, ell[i]);
		}
	}
}
function intclock_event() {
	const ell_event = document.getElementsByClassName('time_countdown_event');
	if (ell_event.length > 0) {
		for (var i = 0; i < ell_event.length; i++) {
			var elele = <Countdownapp_event days={ell_event[i].getAttribute('data-days')} hours={ell_event[i].getAttribute('data-hours')} minute={ell_event[i].getAttribute('data-minute')} sec={ell_event[i].getAttribute('data-sec')} time={ell_event[i].getAttribute('data-time')} zone={ell_event[i].getAttribute('data-zone')} event_id={ell_event[i].getAttribute('data-uatevent-id')} isExpired={ell_event[i].querySelector("div > span.expired") ? "yes" : "no"} element={ell_event[i]} hasExpiredAuction={ell_event[i].getAttribute('hasExpiredAuction')} />;
			ReactDOM.render(elele, ell_event[i]);
		}
	}
}
jQuery(document).ready(function ($) {
	intclock();
	intclock_event();
});

function get_auction_sync_time(getauctionId) {
	jQuery.ajax({
		url: frontend_react_object.ajaxurl,
		type: "post",
		dataType: "json",
		data: {
			action: "get_auction_remaning_time",
			auctionid: getauctionId,
		},
		success: function (data) {
			setCookie("acution_sync_time_" + getauctionId, JSON.stringify(data), '7');
		},
		error: function () {
			console.log('failure!');
		}

	});
}

function get_data_attr_clock(acution, attrnm) {
	return jQuery(acution).attr('data-time');
}
function update_data_attr_clock(setthis, attrnm, attrval) {
	jQuery(setthis).attr(attrnm, attrval);
}

var tabfocused = 0;
function checkTabFocused() {
	if (document.visibilityState === 'visible') {
		/* console.log('✅ browser tab has focus'); */
		tabfocused = 1;
	} else {
		/* console.log('⛔️ browser tab does NOT have focus');*/

	}
}


document.addEventListener('visibilitychange', checkTabFocused);