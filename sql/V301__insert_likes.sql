-- satsuki
INSERT INTO likes (
    send_user_id,
    receive_user_id,
    message_url,
    created,
    modified
)
VALUES
(  
    '100003861936520',
    '100002978382251',
    'http://api.twilio.com/2010-04-01/Accounts/ACf29289f2c695bd6b271be0dff46b649a/Recordings/RE132689e87be87786596f2e3826a36314',
    NOW(),
    NOW()
);
