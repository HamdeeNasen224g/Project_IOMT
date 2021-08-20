function myFunction() {
    // Google sheets
    var ss = SpreadsheetApp.openByUrl('https://docs.google.com/spreadsheets/d/1m0TazrRQGTMd0zyYJTijgw2SdlgXndPaa8mXz9FGDFs/edit?usp=sharing');
    
    //API
    var st =  UrlFetchApp.fetch("https://magellan.ais.co.th/pullmessageapis/api/listen/thing/4F59D67F9BA2BC969B977BBDDE568F15");
    var sst =  UrlFetchApp.fetch("https://magellan.ais.co.th/pullmessageapis/api/listen/thing/59740BBAF7C0BEB8891F1896ADF19ACD");
  
    // data API ST
    var content = st.getContentText();
    var json = JSON.parse(content);
    var ThingName = json["ThingName"];
    var HumidityEVM = json["Sensor"]["HumidityEVM"];
    var Temperature1 = json["Sensor"]["Temperature1"];
    var Temperature2  = json["Sensor"]["Temperature2"];
    var TemperatureEVM = json["Sensor"]["TemperatureEVM"];
  
    // เลือกหน้า Yaring ST
    SpreadsheetApp.setActiveSpreadsheet(ss);
    SpreadsheetApp.setActiveSheet(ss.getSheetByName("Yaring ST"));
  
    activeSheet=ss.getActiveSheet();
    var timestamp = new Date();
    activeSheet.appendRow([timestamp, HumidityEVM,Temperature1,Temperature2,TemperatureEVM]);
  
   // data API SST
     var content = sst.getContentText();
    var json = JSON.parse(content);
    var ThingName = json["ThingName"];
    var HumidityEVM = json["Sensor"]["humidity"];
    var Temperature1 = json["Sensor"]["Temperature1"];
    var Temperature2  = json["Sensor"]["Temperature2"];
    var TemperatureEVM = json["Sensor"]["temperatureEVM"];
    SpreadsheetApp.setActiveSpreadsheet(ss);
    SpreadsheetApp.setActiveSheet(ss.getSheetByName("Yaring SST"));
  
    activeSheet=ss.getActiveSheet();
    activeSheet.appendRow([timestamp, HumidityEVM,Temperature1,Temperature2,TemperatureEVM]);
    
  }