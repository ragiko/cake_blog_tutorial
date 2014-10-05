
<h1>PHONE</h1>
<table align="center">
    <tr>
        <td>
            <h1>Twilio Browser Phone</h1>
            <form>
                <table class="table">
                    <tr>
                        <td>
                            <input class="input-xlarge" type="text" id="client_to_number" name="client_to_number" placeholder="発信先電話番号を入力してください。">
                            <br/>
                            <button class="btn btn-large btn-primary" type="button" id="client_callBtn" name="client_callBtn" onclick="call();">発信</button>
                            <button class="btn btn-large btn-primary" type="button" id="client_hangBtn" name="client_hangBtn" onclick="hangup();">切断</button>
                            <div id="log">Loading pigeons...</div>
                        </td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="http://static.twilio.com/libs/twiliojs/1.2/twilio.min.js"></script>
<script type="text/javascript">
Twilio.Device.setup("<?php echo $token; ?>");

Twilio.Device.ready(function (device) {
    $("#log").text("架電待機");
});

Twilio.Device.error(function (error) {
    $("#log").text("Error: " + error.message);
});

Twilio.Device.connect(function (conn) {
    $("#log").text("架電成功");
});

Twilio.Device.disconnect(function (conn) {
    $("#log").text("架電終了");
});

Twilio.Device.incoming(function (conn) {
    if (confirm('Accept incoming call from ' + conn.parameters.From + '?')){
        connection=conn;
        conn.accept();
    }
});

function call() {
    // get the phone number to connect the call to
    params = {"PhoneNumber": $("#client_to_number").val()};
    Twilio.Device.connect(params);
}

function hangup() {
    Twilio.Device.disconnectAll();
}
</script>

