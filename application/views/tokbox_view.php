<div id='myPublisherDiv'></div> 
<div id='subscribersDiv'></div> 

<script src='//static.opentok.com/v2/js/opentok.min.js'></script> 
<script> 
  var apiKey = '45338472';
  var sessionId = '2_MX40NTMzODQ3Mn5-MTQ0MTkwNzAyMzE2M35kUi9QQStORWZ4RHZBNGliTXNWdWN6QXF-UH4'; 
  var token = 'T1==cGFydG5lcl9pZD00NTMzODQ3MiZzaWc9MWQ3ZWI3MjJkZWVmZjViZmIxMmIxZDMzMjFkMTQxMTFjOGM1ZTNiYzpyb2xlPXB1Ymxpc2hlciZzZXNzaW9uX2lkPTJfTVg0ME5UTXpPRFEzTW41LU1UUTBNVGt3TnpBeU16RTJNMzVrVWk5UVFTdE9SV1o0UkhaQk5HbGlUWE5XZFdONlFYRi1VSDQmY3JlYXRlX3RpbWU9MTQ0MjQ5Nzk3MiZub25jZT0wLjEyNjg5MjEwMjM0ODcxOTQmZXhwaXJlX3RpbWU9MTQ0MjU4NDM3Mg==';
  var session = OT.initSession(apiKey, sessionId); 
  session.on({ 
      streamCreated: function(event) { 
        session.subscribe(event.stream, 'subscribersDiv', {insertMode: 'append'}); 
      } 
  }); 
  session.connect(token, function(error) {
    if (error) {
      console.log(error.message);
    } else {
      session.publish('myPublisherDiv', {width: 320, height: 240}); 
    }
  });
</script>