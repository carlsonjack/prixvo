'use strict';
function getBidIncrementVlaue(jsondata)
{
  const el2 = document.querySelector("#reactplacebid");
  let bid_increment = 0 ;
  if( el2 )
  {
    let props = {
            "incenable":el2.getAttribute('data-inc-enable'),
            "currentbid":el2.getAttribute('data-current-bid'),
            "pricerange":el2.getAttribute('data-price-range'),
            "bidincrement":el2.getAttribute('data-bid-increment'),
            "jsonData":jsondata,
          };
          const incenable = props.incenable;

        const sdata=props.jsonData;
      let currentbid = 0;
      bid_increment = props.bidincrement;
      sdata && sdata.length>0 && sdata.map( function(item, index){
          if( item.woo_ua_auction_current_bid && item.woo_ua_auction_bid_count )
          {
            currentbid = Number(item.woo_ua_auction_current_bid);

          }
      })
      if(currentbid==0) {
        currentbid = Number(props.currentbid);
      }
      if( sdata[0].woo_ua_auction_max_current_bider ){
        if( sdata[0].woo_ua_auction_max_current_bider == uat_data_bid.react_current_user_id )
        {
          currentbid = Number(sdata[0].woo_ua_auction_max_bid) ;
        }
      }
      if(currentbid!=0 && sdata[0].woo_ua_auction_bid_count && incenable != "yes") {
        currentbid = Number(currentbid) ;
      }
    if( bid_increment)
    {
     let teste = currentbid;
     const pricerange = JSON.parse(props.pricerange);

        if(incenable == "yes")
        {
          pricerange.map(function (value, index, array) {
            if (value.start <= teste) {
                bid_increment = Number(value.inc_val);
            }
          })
        }

    }
  }

  const selectDropdown = document.getElementById('reactsel');
  if( selectDropdown )
  {
      let props = {
          "incenable":selectDropdown.getAttribute('data-inc-enable'),
          "currentbid":selectDropdown.getAttribute('data-current-bid'),
          "pricerange":selectDropdown.getAttribute('data-price-range'),
          "bidincrement":selectDropdown.getAttribute('data-bid-increment'),
          "jsonData":jsondata,
        };
        const incenable = props.incenable;
      const sdata=props.jsonData;
      const pricerange = JSON.parse(props.pricerange);
    let currentbid = 0;
    let bid_increment = props.bidincrement;
    sdata && sdata.length>0 && sdata.map( function(item, index){
        if( item.woo_ua_auction_current_bid && item.woo_ua_auction_bid_count )
        {
          currentbid = Number(item.woo_ua_auction_current_bid);
        }
    })
    if(currentbid==0) {
      currentbid = Number(props.currentbid);
    }
    if( sdata[0].woo_ua_auction_max_current_bider ){
      if( sdata[0].woo_ua_auction_max_current_bider == uat_data_bid.react_current_user_id )
      {
        currentbid = Number(sdata[0].woo_ua_auction_max_bid) ;
      }
    }
    if(currentbid!=0 && sdata[0].woo_ua_auction_bid_count && incenable != "yes") {
      currentbid = Number(currentbid) + Number(bid_increment);
    }
    let teste = 0;
    if(incenable == "yes")
    {
      
        teste = Number(currentbid);
      
          pricerange.map(function (value, index, array) {
            if (value.start <= teste) {
                bid_increment = Number(value.inc_val);
            }
          })
    }
  }

  return bid_increment;
}
function showExpiredBox(jsondata){
  if( jsondata[0] ){
    let status = jsondata[0].woo_ua_auction_status;
    let existsTimerBox = document.querySelector(".Estimate-detail")  !== null;
    if(status == "past" && existsTimerBox){
      jQuery('.uat-bid-summary-box-live').show();
      window.location.reload();
    }
  }
}
function showCurrentBid(jsondata){
  const el1 = document.getElementsByClassName('json_current_bid');
  const nextBid = document.getElementsByClassName('json_next_bid');
  const count_elements = document.querySelectorAll('span.auction-bid-count');
  const buy_now_price_hidden = document.querySelector('input#buy-now-price-hidden');
  const reserve_price_elements = document.querySelector('span.auction-reserve-price-text');
  const bid_status_msg_top = document.querySelector('div#bid-status-msg-top');
  const bid_status_msg_outbid = document.querySelector('div#bid-status-msg-outbid');
  let bid_increment = getBidIncrementVlaue(jsondata);
  if(el1.length < 0)
  {
    return false;
  }else{
    for(var i = 0; i < el1.length; i++)
    {
      var nextbidValue = el1[i].textContent ;
      if( jsondata[0] ){
      
        if(jsondata[0].woo_ua_auction_current_bid)
        {
		  nextbidValue = Number(jsondata[0].woo_ua_auction_current_bid) + Number(bid_increment)
		  nextbidValue = new Intl.NumberFormat('en-US', {
					  style: 'decimal',
					  minimumFractionDigits: 2,
					  maximumFractionDigits: 2
					}).format(nextbidValue);
					
		  nextbidValue = Amount_value_with_currency(String( nextbidValue ));	

		 

         
        }
        // hide buy now
        if(buy_now_price_hidden && jsondata[0].woo_ua_auction_current_bid){
          if(parseFloat(buy_now_price_hidden.value) <= parseFloat(jsondata[0].woo_ua_auction_current_bid) )
          {
            jQuery('.buy-now-frm').hide();
          }else{
            jQuery('.buy-now-frm').show();
          }
        }
        // show reserve price text
        if( jsondata[0].uwa_reserve_txt )
        {
          if(reserve_price_elements)
          {
            var uwa_reserve_txt_ = uat_data_bid.reserve_price_not_met;
            var reserve_texts = [];
            reserve_texts.push(uat_data_bid.reserve_price_met);
            reserve_texts.push(uat_data_bid.reserve_price_not_met);
            reserve_texts.push(uat_data_bid.uwa_no_reserve_txt);
            if( jsondata[0].uwa_reserve_txt && reserve_texts.includes(jsondata[0].uwa_reserve_txt) )
            {
              uwa_reserve_txt_ = jsondata[0].uwa_reserve_txt;
            }else{
              if( jsondata[0].woo_ua_auction_reserve_price )
              {
                if( jsondata[0].woo_ua_auction_current_bid  )
                {
                  if( parseFloat(jsondata[0].woo_ua_auction_current_bid) >= parseFloat(jsondata[0].woo_ua_auction_reserve_price )  )
                  {
                    uwa_reserve_txt_ = uat_data_bid.reserve_price_met;
                  }
                }
              }
            }
            reserve_price_elements.innerText  = uwa_reserve_txt_;
          }
        }
        if( document.querySelector("span.auction-max-bid-amount") )
        {
          if( jsondata[0].woo_ua_auction_max_current_bider == uat_data_bid.react_current_user_id )
          {
            var bid_max = jsondata[0].woo_ua_auction_max_bid;
            if(bid_max % 1 != 0){
                bid_max = Number(bid_max).toFixed(2)
            }
            document.querySelector("strong.auction-max-bid-setmsg").style.display = "none";
            document.querySelector("strong.auction-max-bid-maxmsg").style.display = "block";
            document.querySelector("span.auction-max-bid-amount").textContent = " : " + Amount_value_with_currency(bid_max);
            if(bid_max)
            {
              nextbidValue = Amount_value_with_currency(String(Number(bid_max) + Number(bid_increment) ));
            }
          }else{
            document.querySelector("strong.auction-max-bid-setmsg").style.display = "block";
            document.querySelector("strong.auction-max-bid-maxmsg").style.display = "none";
            document.querySelector("span.auction-max-bid-amount").textContent = ""
          }
        }
        let selectBoxHtml = '<span class="woocommerce-Price-amount amount"><bdi>';
              if(jsondata && jsondata.length>0)
              {
                jsondata.map(function(item, index){
                  let bid = "";
                  if( Number(item.woo_ua_auction_current_bid) > Number(el1[0].getAttribute('data-starting')) && item.woo_ua_auction_bid_count){
                    bid = item.woo_ua_auction_current_bid;
                  }else{
                    bid = el1[0].getAttribute('data-starting')
                  }
                  if(bid % 1 != 0){
                    bid = Number(bid).toFixed(2)
                  }
				  
				  bid = new Intl.NumberFormat('en-US', {
					  style: 'decimal',
					  minimumFractionDigits: 2,
					  maximumFractionDigits: 2
					}).format(bid);
					
					
				  if(uat_data_bid.react_currency_pos=="right"){
					
					 selectBoxHtml = selectBoxHtml + bid + '<span class="woocommerce-Price-currencySymbol">'+ uat_data_bid.react_currency_symbol + '</span>' + '</div>';
				  }
				  else if (uat_data_bid.react_currency_pos=="right_space"){
            
					selectBoxHtml = selectBoxHtml + bid + " " + '<span class="woocommerce-Price-currencySymbol">'+ uat_data_bid.react_currency_symbol + '</span>' + '</div>';
				  }
				  else if (uat_data_bid.react_currency_pos=="left_space"){
					
					selectBoxHtml = selectBoxHtml + '<span class="woocommerce-Price-currencySymbol">'+ uat_data_bid.react_currency_symbol + '</span>' + " " + bid +'</div>';
				  }
				  else {
					
					selectBoxHtml = selectBoxHtml + '<span class="woocommerce-Price-currencySymbol">'+ uat_data_bid.react_currency_symbol + '</span>' + bid +'</div>';
				  }	
								  
				  
                 
				 
                } )
              }
              selectBoxHtml = selectBoxHtml + '</bdi></span>';
              el1[0].innerHTML = selectBoxHtml;
        /* show Next Minimum Bid */
        if(nextBid.length){
          nextBid[0].innerHTML = nextbidValue;
        }
      }
    }
  }
}

function DropdownbidNew(jsondata)
{
  const el2 = document.getElementById('reactsel');
        if( el2 )
        {
            let props = {
                "totalbid":el2.getAttribute('data-total-bids'),
                "incenable":el2.getAttribute('data-inc-enable'),
                "currentbid":el2.getAttribute('data-current-bid'),
                "pricerange":el2.getAttribute('data-price-range'),
                "userid":el2.getAttribute('data-userid'),
                "bidincrement":el2.getAttribute('data-bid-increment'),
                "jsonData":jsondata,
              };
              const incenable = props.incenable;
            const sdata=props.jsonData;
            let suserid = props.userid;
            const pricerange = JSON.parse(props.pricerange);
          let currentbid = 0;
          let bid_increment = props.bidincrement;
          sdata && sdata.length>0 && sdata.map( function(item, index){
              if( item.woo_ua_auction_current_bid && item.woo_ua_auction_bid_count )
              {
                currentbid = Number(item.woo_ua_auction_current_bid);
              }
          })
          if(currentbid==0) {
            currentbid = Number(props.currentbid);
          }
          if( sdata[0].woo_ua_auction_max_current_bider ){
            if( sdata[0].woo_ua_auction_max_current_bider == uat_data_bid.react_current_user_id )
            {
              currentbid = Number(sdata[0].woo_ua_auction_max_bid) ;
            }
          }
          if(currentbid!=0 && sdata[0].woo_ua_auction_bid_count && incenable != "yes") {
            currentbid = Number(currentbid) + Number(bid_increment);
          }
          let teste = 0;
        // let bid_increment = props.bidincrement;
          let dropdown_value = 0;
          let item = 0;
          let fdata = [];
          for(let j=1; j <= props.totalbid; j++)
            {
                if(incenable == "yes")
                {
                  if(j==1)
                  {
                    item = Number(currentbid);
                    teste = Number(currentbid);
                  }
                      pricerange.map(function (value, index, array) {
                        if (value.start <= teste) {
                            bid_increment = Number(value.inc_val);
                        }
                      })
                      dropdown_value = bid_increment;
                    teste = Number(teste) + Number(dropdown_value);
                    item = Number(item) + Number(dropdown_value);
                } else {
                  if (j == 1) {
                      dropdown_value = Number(currentbid);
                  } else {
                      dropdown_value = Number(bid_increment);
                  }
                  item = Number(item) + Number(dropdown_value);
                }
                if(item % 1 != 0){
                  item = Number(item).toFixed(2)
                }
                fdata.push(item);
            }
            let selectBoxHtml = "";
            selectBoxHtml = selectBoxHtml + '<select key="'+Math.random()+'" name="uat_bid_value"  id="uat_bid_value" >';
            if(fdata && fdata.length>0)
            {
              fdata.map(function(item, index){
                selectBoxHtml = selectBoxHtml + '<option key="'+Math.random()+'" value="'+item+'">'+ Amount_value_with_currency(item)+'</option>';
              } )
            }
            selectBoxHtml = selectBoxHtml + '</select>';
            el2.innerHTML = selectBoxHtml;
      }

 return "";
}

function checkAndUpdateTimeString(jsondata){
  const el2 = document.querySelector(".auction-ends-date");
  return;
  if( el2 )
  {
    if(jsondata && jsondata.length>0)
    {
      if(jsondata[jsondata.length - 1]['woo_ua_auction_end_date_']){
        
        el2.innerHTML = jsondata[jsondata.length - 1]['woo_ua_auction_end_date_formated_with_timezone'];
      }
    }
  }
}

function quickBidButtons(jsondata){
  const el2 = document.querySelector("#reactplacebid");
  const quickbtns = document.querySelector(".quick-bid-btns");
  const bid_directly_input = document.querySelector(".bid_directly_input");
  const max_bid_directly_input = document.querySelector(".max_bid_directly_input");

  if( el2 )
  {
    let props = {
            "totalbid":el2.getAttribute('data-total-bids'),
            "incenable":el2.getAttribute('data-inc-enable'),
            "currentbid":el2.getAttribute('data-current-bid'),
            "pricerange":el2.getAttribute('data-price-range'),
            "userid":el2.getAttribute('data-userid'),
            "bidincrement":el2.getAttribute('data-bid-increment'),
            "jsonData":jsondata,
          };
          const incenable = props.incenable;

        const sdata=props.jsonData;
      let currentbid = 0;
      let bid_increment = props.bidincrement;
      sdata && sdata.length>0 && sdata.map( function(item, index){
          if( item.woo_ua_auction_current_bid && item.woo_ua_auction_bid_count )
          {
            currentbid = Number(item.woo_ua_auction_current_bid);

          }
      })
      if(currentbid==0) {
        currentbid = Number(props.currentbid);
      }
      if( sdata[0].woo_ua_auction_max_current_bider ){
        if( sdata[0].woo_ua_auction_max_current_bider == uat_data_bid.react_current_user_id )
        {
          currentbid = Number(sdata[0].woo_ua_auction_max_bid) ;
        }
      }
      if(currentbid!=0 && sdata[0].woo_ua_auction_bid_count && incenable != "yes") {
        currentbid = Number(currentbid) ;
      }
    if(currentbid && bid_increment && quickbtns)
    {
     var quickBidButtonHtml = "";
     var buttonPrice = currentbid;
     var numberQuickBidButtons = 3;
     let teste = currentbid;
     const pricerange = JSON.parse(props.pricerange);
     var firstbtn = 0;
     for(let j=1; j <= numberQuickBidButtons; j++)
     {
        if(incenable == "yes")
        {
          pricerange.map(function (value, index, array) {
            if (value.start <= teste) {
                bid_increment = Number(value.inc_val);
            }
          })
          teste = Number(teste) + Number(bid_increment);
          if( j == 1 ){
            firstbtn = Number(buttonPrice) + Number(bid_increment);
          }
          buttonPrice = Number(buttonPrice) + Number(bid_increment);

        } else {

          if( j == 1 ){
            firstbtn = Number(buttonPrice) + Number(bid_increment);
          }
          buttonPrice = Number(buttonPrice) + Number(bid_increment);
        }
        if(j == 1 && !sdata[0].woo_ua_auction_bid_count){
          buttonPrice = currentbid;
          teste = currentbid;
          firstbtn = currentbid;
        }
       if(buttonPrice % 1 != 0){
          buttonPrice = Number(buttonPrice).toFixed(2)
       }
      quickBidButtonHtml = quickBidButtonHtml + '<button class="black_bg_btn quick_bid_button_one" data-bid-amount="'+buttonPrice+'"> '+Amount_value_with_currency(buttonPrice)+'</button>';
     }
     quickbtns.innerHTML = quickBidButtonHtml;
    }
    if(bid_directly_input){
      bid_directly_input.dataset.currentBid = firstbtn;
      bid_directly_input.min = firstbtn;
      bid_directly_input.step = bid_increment;
      // bid_directly_input.value = firstbtn;
    }
    if(max_bid_directly_input){
      if( sdata[0].woo_ua_auction_max_current_bider ){
        if( sdata[0].woo_ua_auction_max_current_bider == uat_data_bid.react_current_user_id )
        {
          max_bid_directly_input.dataset.maxBid = parseFloat(sdata[0].woo_ua_auction_max_bid)+parseFloat(bid_increment);
          max_bid_directly_input.dataset.isMax = "1";
          max_bid_directly_input.min = parseFloat(sdata[0].woo_ua_auction_max_bid)+parseFloat(bid_increment);
          max_bid_directly_input.step = bid_increment;
        }else{
          max_bid_directly_input.dataset.maxBid = parseFloat(firstbtn);
          max_bid_directly_input.dataset.isMax = "0";
          max_bid_directly_input.min = firstbtn;
          max_bid_directly_input.step = bid_increment;
        }
      }else{
        max_bid_directly_input.dataset.maxBid = parseFloat(firstbtn);
        max_bid_directly_input.dataset.isMax = "0";
        max_bid_directly_input.min = firstbtn;
        max_bid_directly_input.step = bid_increment;
      }
    }
  }
}

function Amount_value_with_currency(amount){
	  
 if(uat_data_bid.react_currency_pos=="right"){
	var f_amount = amount + uat_data_bid.react_currency_symbol;  
  }
  else if (uat_data_bid.react_currency_pos=="right_space"){
	var f_amount = amount + " " + uat_data_bid.react_currency_symbol ;
  }
  else if (uat_data_bid.react_currency_pos=="left_space"){
	var f_amount = uat_data_bid.react_currency_symbol + " " + amount;
  }
  else {
	var f_amount = uat_data_bid.react_currency_symbol + amount;
  }	
	return f_amount;
}


