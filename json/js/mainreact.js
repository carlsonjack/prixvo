'use strict';
function MainReactApp(props) {
  const [jsondata,setJsonData]=React.useState([]);
  const [jsonbidsdata,setJsonBidsData]=React.useState([]);
  const [jsoncallcount,setJsonCallCount]=React.useState(0);
  const [bidstotal,setBidsTotal]=React.useState(0);
  const [lastbidder,setLastBidder]=React.useState(0);
  const [hasloaded,setHasLoaded]=React.useState(false);
  const [hastimesnipped,setHasTimeSnipped]=React.useState(false);
  let auctionId = props.auctionId;
  let url_json = frontend_react_object.react_uploadurl;
  let url_object = new URL(url_json);
  let protocol = url_object.protocol;

  React.useEffect(() =>{
    if(lastbidder != 0 && hastimesnipped){
      anti_sniping_timer_update()
    }
  },[hastimesnipped]);
  if(document.location.protocol != protocol)
  {
    url_json = url_json.replace(protocol, document.location.protocol);
  }
  const getJsonData=async()=>{
    const res = await fetch(url_json+'/auction_json/'+auctionId+'.json',{
      headers : {
        'Content-Type': 'application/json',
        'Cache-Control': 'no-cache',
        'Accept': 'application/json',
        'Access-Control-Allow-Origin': '*',
        }
    });
    const myJson = await res.json();

    setJsonData(myJson)
  }
  const getJsonBidsData=async()=>{
      const res = await fetch(url_json+'/auction_json/'+auctionId+'_bids.json?randomlist='+Math.random(),{
        headers : {
          'Content-Type': 'application/json',
          'Cache-Control': 'no-cache',
          'Accept': 'application/json',
          'Access-Control-Allow-Origin': '*',
        }
      });
      const myJsonBids = await res.json();
 
      setJsonBidsData(myJsonBids)
      if(myJsonBids.length > 0){
        var lastItem = myJsonBids.at(-1)
        setBidsTotal(myJsonBids.length)
        setLastBidder(lastItem.woo_ua_auction_user_id)
        if(hasloaded && bidstotal != myJsonBids.length){
          setHasTimeSnipped(lastItem.has_time_sniping)
		  document.querySelector("#refresh_comment a").click();
        }
      }
      setHasLoaded(true)
  }
  if(jsoncallcount == 1){
    getJsonData();
    getJsonBidsData();
  }
  React.useEffect(function () {
    // if json data
	
    if( jsondata.length > 0 )
    {  
      // show dropdown box
	    if(!hasloaded){
        DropdownbidNew(jsondata);
      }else{
        if(jsondata[0].woo_ua_auction_bid_count != jsonbidsdata.length && jsonbidsdata.length > 0){
          // show dropdown box
          DropdownbidNew(jsondata);
        }
      }
      quickBidButtons(jsondata);
      // show current bids
      showCurrentBid(jsondata);
      showExpiredBox(jsondata);
      // update timeString
      checkAndUpdateTimeString(jsondata);
    }
    const interval = setInterval(() => {
      getJsonData();
      getJsonBidsData();
    }, 5000);
    setJsonCallCount(jsoncallcount + 1);
    return () => clearInterval(interval);
  }, [jsondata]);

  React.useEffect(function () {
    // if json bids data
    if( jsonbidsdata.length > 0 )
    {
      // show bid notifications
      showBidNotifications(jsonbidsdata);
	 
    }
    // show bid list
    showBidList(auctionId,jsonbidsdata,jsondata);
  }, [jsonbidsdata]);
  return "";

}

var ele = document.querySelector(".react-div");
  if(ele)
  {
    let auctionId = ele.getAttribute("data-auction-id");
    ReactDOM.render(<MainReactApp auctionId={auctionId} />, ele);
  }