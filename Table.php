
<?php include 'db_con.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon.png">
  <link rel="icon" type="image/png" href="../img/favicon.png">
  <title>
    Dashboard Walailak University Hospital
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="../css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="../css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../demo/demo.css" rel="stylesheet" />
</head>
<body class="">
<div class="container">

  <table id="example" class="table table-striped table-bordered" style="width:100%">
  <?php include 'pulldatafromdatabase.php'; ?>
    <thead class="thead-light">
   
    <tr>
        <th>ID</th>
        <th>Disease</th>
        <th>ICD-10</th>
        <th>Type</th>
        <th>Type</th>
        <th>Type</th>
        <th>Type</th>
        <th>Type</th>
        <th>Type</th>
        <th>Type</th>
        <th><button type="button" class="btn btn-success" id="btn-add" >New</button></th>
      </tr>
    </thead>
    <tbody>
    <?php  ?>
                
              <tr>
                <td><?php echo $blood_id ;?></td>
                <td><?php echo $blood_name ;?></td>
                <td><?php echo $hid ;?></td>
                <td><?php echo $p_Fname ;?></td>
                <td><?php echo $p_Lname ;?></td>
                <td><?php echo $dob ;?></td>
                <td><?php echo $address ;?></td>
                <td><?php echo $zipcode ;?></td>
                <td><?php echo $weight ;?></td>
                <td><?php echo $height ;?></td>
                <td><?php echo $timestamp ;?></td>
            </tr>
     
    </tbody>
  </table>

  <script src="https://developers.google.com/apps-script/api/quickstart/nodejs#step_2_set_up_the_sample"></script>
<script>

$(
  const fs = require('fs');
const readline = require('readline');
const {google} = require('googleapis');

// If modifying these scopes, delete token.json.
const SCOPES = ['https://www.googleapis.com/auth/script.projects'];
// The file token.json stores the user's access and refresh tokens, and is
// created automatically when the authorization flow completes for the first
// time.
const TOKEN_PATH = 'token.json';

// Load client secrets from a local file.
fs.readFile('credentials.json', (err, content) => {
  if (err) return console.log('Error loading client secret file:', err);
  // Authorize a client with credentials, then call the Google Apps Script API.
  authorize(JSON.parse(content), callAppsScript);
});

/**
 * Create an OAuth2 client with the given credentials, and then execute the
 * given callback function.
 * @param {Object} credentials The authorization client credentials.
 * @param {function} callback The callback to call with the authorized client.
 */
function authorize(credentials, callback) {
  const {client_secret, client_id, redirect_uris} = credentials.installed;
  const oAuth2Client = new google.auth.OAuth2(
      client_id, client_secret, redirect_uris[0]);

  // Check if we have previously stored a token.
  fs.readFile(TOKEN_PATH, (err, token) => {
    if (err) return getAccessToken(oAuth2Client, callback);
    oAuth2Client.setCredentials(JSON.parse(token));
    callback(oAuth2Client);
  });
}

/**
 * Get and store new token after prompting for user authorization, and then
 * execute the given callback with the authorized OAuth2 client.
 * @param {google.auth.OAuth2} oAuth2Client The OAuth2 client to get token for.
 * @param {getEventsCallback} callback The callback for the authorized client.
 */
function getAccessToken(oAuth2Client, callback) {
  const authUrl = oAuth2Client.generateAuthUrl({
    access_type: 'offline',
    scope: SCOPES,
  });
  console.log('Authorize this app by visiting this url:', authUrl);
  const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout,
  });
  rl.question('Enter the code from that page here: ', (code) => {
    rl.close();
    oAuth2Client.getToken(code, (err, token) => {
      if (err) return console.error('Error retrieving access token', err);
      oAuth2Client.setCredentials(token);
      // Store the token to disk for later program executions
      fs.writeFile(TOKEN_PATH, JSON.stringify(token), (err) => {
        if (err) return console.error(err);
        console.log('Token stored to', TOKEN_PATH);
      });
      callback(oAuth2Client);
    });
  });
}

/**
 * Creates a new script project, upload a file, and log the script's URL.
 * @param {google.auth.OAuth2} auth An authorized OAuth2 client.
 */
function callAppsScript(auth) {
  const script = google.script({version: 'v1', auth});
  script.projects.create({
    resource: {
      title: 'My Script',
    },
  }, (err, res) => {
    if (err) return console.log(`The API create method returned an error: ${err}`);
    script.projects.updateContent({
      scriptId: res.data.scriptId,
      auth,
      resource: {
        files: [{
          name: 'hello',
          type: 'SERVER_JS',
          source: 'function helloWorld() {\n  console.log("Hello, world!");\n}',
        }, {
          name: 'appsscript',
          type: 'JSON',
          source: '{\"timeZone\":\"America/New_York\",\"exceptionLogging\":' +
           '\"CLOUD\"}',
        }],
      },
    }, {}, (err, res) => {
      if (err) return console.log(`The API updateContent method returned an error: ${err}`);
      console.log(`https://script.google.com/d/${res.data.scriptId}/edit`);
    });
  });
}
   })
</script>
</div>
 
<script>
    $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>

</body>
</html>
 <?php 
$conn->close();
?>