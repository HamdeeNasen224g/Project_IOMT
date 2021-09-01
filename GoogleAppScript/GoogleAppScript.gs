
function myFunction() {
    // Google sheets
    var ss = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1QfE0M5o-lNz7Lr5RkEaPbEzHpKQ4ZbS1MFhXOa2PLgM/edit#gid=0');
    var workSheetName = "data1"; 
    var data = doGet();
    var check = 0 ;
    console.log(data);
    //API
    var st =  UrlFetchApp.fetch("https://api.thingspeak.com/channels/1483314/feeds.json?api_key=0XNU6KDCBYBZVW0U&results=1");
    
    // data API ST
    var content = st.getContentText();
    var json = JSON.parse(content);

 var timestamp = json.feeds[0].created_at;
 var feed_id = json.feeds[0].entry_id;
    var id = json.channel.id;
    var bpm = json.feeds[0].field1;
  var spo2 = json.feeds[0].field2;
  var temp = json.feeds[0].field3;
  
   var data = doGet(timestamp,feed_id,id);
   console.log(data);
    if(data == 1){
    // เลือกหน้า sheet
    SpreadsheetApp.setActiveSpreadsheet(ss);
    SpreadsheetApp.setActiveSheet(ss.getSheetByName(workSheetName));
  
   activeSheet=ss.getActiveSheet();
   activeSheet.appendRow([timestamp,feed_id, id,bpm,spo2,temp]);
   sendLineNotify(timestamp,bpm,spo2,temp);
   alert(bpm,spo2);
    }
  }


function doGet(test1,test2,test3) {
  // sheet id 
  var ssread = SpreadsheetApp.openById("1QfE0M5o-lNz7Lr5RkEaPbEzHpKQ4ZbS1MFhXOa2PLgM");
  SpreadsheetApp.setActiveSheet(ssread.getSheetByName("console"));
  var sheet = ssread.getActiveSheet();
  var check = 0;
  var check1 = SpreadsheetApp.getActiveSheet().getRange(2, 1).getValue();
  var check2 = SpreadsheetApp.getActiveSheet().getRange(2, 2).getValue();
  var check3 = SpreadsheetApp.getActiveSheet().getRange(2, 3).getValue();
  if(test1 == check1 && test2 == check2 && check3 == test3){
  check = 0; }else{ check = 1; }
  console.log(check1+" "+check2+" "+check3);
  const values = sheet.getRange(2, 1, sheet.getLastRow() - 1, sheet.getLastColumn()).getValues();
  // Converts data rows in json format
  const result = values.map(([a, b, c ]) => {
    return ({ timestamp: a, Feed_id: b,Chanel_ID: c})
  })

  //console.log(result);
  return check;
 // return ContentService.createTextOutput(JSON.stringify(result)).setMimeType(ContentService.MimeType.JSON);
  }



function cnvToThaiDateTime_(vDate) {
  
  var d = new Date(vDate);
var formattedDate = d.getDate() + "-" + (d.getMonth() + 1) + "-" + d.getFullYear();
var hours = (d.getHours() < 10) ? "0" + d.getHours() : d.getHours();
var minutes = (d.getMinutes() < 10) ? "0" + d.getMinutes() : d.getMinutes();
var formattedTime = hours + ":" + minutes;

return formattedDate = formattedDate + " เวลา" + formattedTime + " น.";
 
}


function sendLineNotify(data1,data2,data3,data4) {
  var time = cnvToThaiDateTime_(data1);
  var messages = {
        "message": "\nHello นายท่าน"+'\n'+'ข้อมูลวันที่ : '+ time   + '\n' +
                        'ค่าชีพจร : '+ data2   + ' BPM\n' +
                        'ค่าระดับออกซิเจนในเลือด Spo2 : '     + data3 + '%\n' +
                        'อุณหภูมิ : '   + data4+ " ํC\n",
        "stickerPackageId": "1",
        "stickerId": "14"
      };
  var messages = {
        "message": "\nHello นายท่าน"+'\n'+'ข้อมูลวันที่ : '+ time   + '\n' +
                        'ค่าชีพจร : '+ data2   + ' BPM\n' +
                        'ค่าระดับออกซิเจนในเลือด Spo2 : '     + data3 + '%\n' +
                        'อุณหภูมิ : '   + data4+ " ํC\n",
        "stickerPackageId": "1",
        "stickerId": "14"
      };

  var url = "https://notify-api.line.me/api/notify";
  var token = "cvamHIAsCMlPKswDH8DdMHzYO9Dp4H2vJDe43NC8I7D";
  var options = {
      "method": "post",
      "payload": messages,
      "headers": {
        "Authorization": "Bearer " + token
       }
  };
  
  UrlFetchApp.fetch(url, options);
}


function alert(data2,data3) {
  if((data2 > 100 || data2 < 60)||data3 < 80 ){
  var messages = {
        "message": "\nนายท่าน แจ้งเตือนฉุกเฉิน \udbc0\udc9b"+'\n'+'โปรดตรวจสอบญาติของท่าน\n' +
                        '\udbc0\udca4 ค่าชีพจรหรือค่าระดับออกซิเจนในเลือดของนายท่านอยู่ในเกณฑ์ผิดปกติ \udbc0\udca4 \n' +
                        '\udbc0\udc1c หากสภาพนายท่านดูไม่ดี \udbc0\udc13 \n' +
                        'โปรดติดต่อ แจ้งสายด่วน 1330 แล้วกด 14'+ " \n \udbc0\udc4e",
        "stickerPackageId": "1",
        "stickerId": "16"
      };
  
  var url = "https://notify-api.line.me/api/notify";
  var token = "cvamHIAsCMlPKswDH8DdMHzYO9Dp4H2vJDe43NC8I7D";
  var options = {
      "method": "post",
      "payload": messages,
      "headers": {
        "Authorization": "Bearer " + token
       }
  };

  UrlFetchApp.fetch(url, options);
  sendImgLineNotify();
  }
}

function sendImgLineNotify(){
var token = "cvamHIAsCMlPKswDH8DdMHzYO9Dp4H2vJDe43NC8I7D";
var message = "โปรดปฏิบัติตามภาพด้านล่าง!";
var imgThumbnail = "https://www.kkh.go.th/wp-content/uploads/2020/04/90133470_2983699621669743_2146197842165760000_n.jpg"; // Maximum size of 240×240px JPEG
var imgFullsize = "https://www.kkh.go.th/wp-content/uploads/2020/04/90133470_2983699621669743_2146197842165760000_n.jpg"; //Maximum size of 1024×1024px JPEG
var formData = {
'message' : message,
'imageThumbnail': imgThumbnail,
'imageFullsize' : imgFullsize,
}

var options = {
"method" : "post",
"payload" : formData,
"headers" : {"Authorization" : "Bearer " + token}
};
UrlFetchApp.fetch("https://notify-api.line.me/api/notify", options);
}

