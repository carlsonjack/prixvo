'use strict';

function showBidList(auctionId, myJson, jsondata) {
  var ele = document.querySelector("tbody.uaw-auction-bid-list");
  var bidsTable = document.querySelector(".bid-table-box");
  var starting_bid_text = document.querySelector(".starting-bid-text");
  var current_bid_text = document.querySelector(".current-bid-text");

  const count_elements = document.querySelectorAll('span.auction-bid-count');
  const bid_status_msg_top = document.querySelector('div#bid-status-msg-top');
  const bid_status_msg_outbid = document.querySelector('div#bid-status-msg-outbid');

  if (myJson.length > 0) {
    const uniqueUsers = [...new Set(myJson.map(item => item.woo_ua_auction_user_id))];
    if (uniqueUsers.includes(parseInt(uat_data_bid.react_current_user_id))) {
      if (jsondata[0] && bid_status_msg_top) {
        if (jsondata[0].woo_ua_auction_max_current_bider && uat_data_bid.react_current_user_id != '0') {
          if (jsondata[0].woo_ua_auction_max_current_bider == uat_data_bid.react_current_user_id) {
            bid_status_msg_top.style.display = "block";
            bid_status_msg_outbid.style.display = "none";
          } else {
            bid_status_msg_top.style.display = "none";
            bid_status_msg_outbid.style.display = "block";
          }
        } else {
          if (jsondata[0].woo_ua_auction_current_bider && uat_data_bid.react_current_user_id != '0') {
            if (jsondata[0].woo_ua_auction_current_bider == uat_data_bid.react_current_user_id) {
              bid_status_msg_top.style.display = "block";
              bid_status_msg_outbid.style.display = "none";
            } else {
              bid_status_msg_top.style.display = "none";
              bid_status_msg_outbid.style.display = "block";
            }
          }
        }
      }
    }
  }
  if (starting_bid_text || current_bid_text) {
    if (myJson.length > 0) {
      current_bid_text.style.display = "block";
      starting_bid_text.style.display = "none";
    } else {
      starting_bid_text.style.display = "block";
      current_bid_text.style.display = "none";
    }
  }

  for (var i = 0; i < count_elements.length; i++) {
    count_elements[i].innerText = myJson.length;
  }
  if (ele) {

    let bidListHtml = "";
    if (myJson.length > 0) {
      myJson.reverse();
      // bidListHtml = bidListHtml + '<select key="'+Math.random()+'" name="uat_bid_value"  id="uat_bid_value" >';
      if (myJson && myJson.length > 0) {
        myJson.map(function (item, index) {
          var bidType = "";
          var biddername = item.woo_ua_auction_user_name;
          var bidamount = item.woo_ua_auction_bid_amount;
		  
		   bidamount = new Intl.NumberFormat('en-US', {
					  style: 'decimal',
					  minimumFractionDigits: 2,
					  maximumFractionDigits: 2
					}).format(bidamount);
		  
          if (item.woo_ua_auction_bid_proxy) {
            bidType = 'Yes';
          }
          if (item.woo_ua_auction_id == auctionId) {

            if (uat_data_bid.react_user_is_admin !== '1' && uat_data_bid.product_owner_id !== uat_data_bid.react_current_user_id) {
              if (item.woo_ua_auction_user_id != uat_data_bid.react_current_user_id) {
                if (uat_data_bid.uat_simple_maskusername_enable == 'on') {
                  biddername = item.woo_ua_auction_user_name_proxy_mask;
                } else if (uat_data_bid.uat_proxy_maskusername_enable == 'on') {
                  biddername = item.woo_ua_auction_user_name_proxy_mask;
                } else if (uat_data_bid.uat_silent_maskusername_enable == 'on') {
                  biddername = item.woo_ua_auction_user_name_silent_mask;
                } else {

                }

                if (uat_data_bid.options_uat_proxy_maskbid_enable == 'on') {
                  bidamount = item.woo_ua_auction_bid_amount_mask;
                } else if (uat_data_bid.options_uat_silent_maskbid_enable == 'on') {
                  bidamount = item.woo_ua_auction_bid_amount_mask;
                } else {

                }
              }
            }

          }
			var datetime = getDateTimeFromJson(item.woo_ua_auction_bid_time);
			var timezone = item.woo_ua_auction_end_date_formated_with_timezone;
			var timeZone = timezone.match(/\(([^)]+)\)/)[1];
			
			var timeAgo = customTimeAgo(item.woo_ua_auction_bid_time,timeZone);
			bidListHtml = bidListHtml + '<td className="bid_username">' + biddername + '</td>';
			bidListHtml = bidListHtml + '<td className="bid_date">' + timeAgo +'</td>';

          if (uat_data_bid.react_currency_pos == "right") {
            bidListHtml = bidListHtml + '<td className="bid_price">' + bidamount + uat_data_bid.react_currency_symbol + '</td>';
          }
          else if (uat_data_bid.react_currency_pos == "right_space") {
            bidListHtml = bidListHtml + '<td className="bid_price">' + bidamount + " " + uat_data_bid.react_currency_symbol + '</td>';
          }
          else if (uat_data_bid.react_currency_pos == "left_space") {
            bidListHtml = bidListHtml + '<td className="bid_price">' + uat_data_bid.react_currency_symbol + " " + bidamount + '</td>';
          }
          else {
            bidListHtml = bidListHtml + '<td className="bid_price">' + uat_data_bid.react_currency_symbol + bidamount + '</td>';
          }

          if (uat_data_bid.is_proxy_auction && uat_data_bid.is_proxy_auction == 'yes') {
            bidListHtml = bidListHtml + '<td className="proxy">' + bidType + '</td>';
          }
          bidListHtml = bidListHtml + '</tr>';
        })
      }
      bidsTable.style.display = "block";
    } else {
      bidsTable.style.display = "none";
      bidListHtml = bidListHtml + '<tr>';
      bidListHtml = bidListHtml + '<td colspan="4" style="text-align: center;">' + uat_data_bid.nobid_text + '</td>';
      bidListHtml = bidListHtml + '</tr>';      
    }
    ele.innerHTML = bidListHtml;
  }
}


/*function getDateTimeFromJson(jsonDateTime) {
  const [datePart, timePart] = jsonDateTime.split(' ');
  const [year, month, day] = datePart.split('-');
  const [hour, minute, second] = timePart.split(':');

  return new Date(year, month - 1, day, hour, minute, second);
}
function customTimeAgo(datetime) {
	const nowtime = uat_data_bid.uwa_now_time;
	const diff = getDateTimeFromJson(nowtime) - getDateTimeFromJson(datetime);
  
	if (diff < 0) {
		const secondsToFuture = Math.abs(Math.floor(diff / 1000));
		return `${secondsToFuture} ${secondsToFuture === 1 ? 'second ago' : 'seconds ago'}`;

	}
	const seconds = Math.floor(diff / 1000);  
	const minutes = Math.floor(seconds / 60);
	const hours = Math.floor(minutes / 60);
	const days = Math.floor(hours / 24);
	const months = Math.floor(days / 30);
	const years = Math.floor(months / 12);

	if (years >= 1) {
		return years === 1 ? "1 year ago" : `${years} years ago`;
	} else if (months >= 1) {
		return months === 1 ? "1 month ago" : `${months} months ago`;
	} else if (days >= 1) {
		return days === 1 ? "1 day ago" : `${days} days ago`;
	} else if (hours >= 1) {
		return hours === 1 ? "1 hour ago" : `${hours} hours ago`;
	} else if (minutes >= 1) {
		return minutes === 1 ? "1 minute ago" : `${minutes} minutes ago`;
	} else {
		return seconds === 1 ? "1 second ago" : `${seconds} seconds ago`;
	}
}
*/


function getDateTimeFromJson(jsonDateTime) {
  const [datePart, timePart] = jsonDateTime.split(' ');
  const [year, month, day] = datePart.split('-');
  const [hour, minute, second] = timePart.split(':');

  return new Date(year, month - 1, day, hour, minute, second);
}


function customTimeAgo(datetime,timeZone) {
	const now = new Date();
  
	const options = { timeZone: timeZone, hour12: false };

	// Get individual components of the date and time
	const year = new Intl.DateTimeFormat('en', { ...options, year: 'numeric' }).format(now);
	const month = new Intl.DateTimeFormat('en', { ...options, month: '2-digit' }).format(now);
	const day = new Intl.DateTimeFormat('en', { ...options, day: '2-digit' }).format(now);
	const hour = new Intl.DateTimeFormat('en', { ...options, hour: '2-digit' }).format(now);
	const minute = new Intl.DateTimeFormat('en', { ...options, minute: '2-digit' }).format(now);
	const second = new Intl.DateTimeFormat('en', { ...options, second: '2-digit' }).format(now);

	// Construct the formatted date and time string
	const formattedDateTime = `${year}-${month}-${day} ${hour}:${minute}:${second}`;


	// Log the formatted date and time
	console.log(formattedDateTime+'---'+datetime);
	
  
	const diff = getDateTimeFromJson(formattedDateTime) - getDateTimeFromJson(datetime);

	const seconds = Math.floor(diff / 1000);
	const minutes = Math.floor(seconds / 60);
	const hours = Math.floor(minutes / 60);
	const days = Math.floor(hours / 24);
	const months = Math.floor(days / 30);
	const years = Math.floor(months / 12);

	  if (years >= 1) {
		return years === 1 ? "1 year ago" : `${years} years ago`;
	  } else if (months >= 1) {
		return months === 1 ? "1 month ago" : `${months} months ago`;
	  } else if (days >= 1) {
		return days === 1 ? "1 day ago" : `${days} days ago`;
	  } else if (hours >= 1) {
		return hours === 1 ? "1 hour ago" : `${hours} hours ago`;
	  } else if (minutes >= 1) {
		return minutes === 1 ? "1 minute ago" : `${minutes} minutes ago`;
	  } else {
		return seconds === 1 ? "1 second ago" : `${seconds} seconds ago`;
	  }
}