function getAccessToken() {
    console.log("Test");
    CONSUMER_KEY = "ihdbALW0yeA54mcZXOeGqMWDFv7W8pDr";
    CONSUMER_SECRET = "9kNhjDlyxlnlMQHV";
    token_request = new XMLHttpRequest();
    url = "https://tapi.telstra.com/v2/oauth/token";
    params = "&grant_type=client_credentials&client_id=" + CONSUMER_KEY + "&client_secret=" + CONSUMER_SECRET + "&scope=NSMS";

    token_request.open("POST", url, true);
    token_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    token_request.onreadystatechange = function (ev) {
        ev.preventDefault();
        if (token_request.readyState == 4 && token_request.status == 200) {
            token = JSON.parse(token_request.responseText)["access_token"];
            console.log(token);
            // token_request.close();
            return token;
        } else {
            alert(token_request.status);
        }
    };

    token_request.send(params);
}

function getNumber(accessToken) {
    url = "https://tapi.telstra.com/v2/messages/provisioning/subscriptions";
    number_request = new XMLHttpRequest();
    params = {
        "activeDays": 30,
        "notifyURL": "http://abcd.com",
        "callbackData":
            {
                "anything": "abc"
            }
    };
    number_request.open("POST", url, true);
    // number_request.setRequestHeader("User-Agent", "Rigor API Tester");
    // number_request.setRequestHeader("Host", "tapi.telstra.com");
    number_request.setRequestHeader("Accept", "*/*");
    number_request.setRequestHeader("Authorization", "Bearer " + accessToken);
    // number_request.setRequestHeader("Access-Control", "allow");
    number_request.setRequestHeader("Cache-control", "no-cache");
    number_request.setRequestHeader("Content-type", "application/json");
    // number_request.setRequestHeader("Content-length", "165");

    // number_request.onreadystatechange = function () {
    //     if (number_request.status == 200) {
    //         return JSON.parse(number_request.responseText)["destinationAddress"];
    //     } else {
    //         console.log(number_request.status);
    //         console.log(number_request.responseText);
    //     }
    // };
    number_request.send(params);

}


function sendSMS(accessToken, fromNumber, toNumber) {
    url = "https://tapi.telstra.com/v2/messages/sms";
    request = new XMLHttpRequest();
    request.open("POST", url, false);
    request.setRequestHeader("Authorization", "Bearer " + accessToken);
    request.setRequestHeader("Content-type", "application/json");
    // request.setRequestHeader("Access-Control-Allow-Origin", "true");
    params = {
        "to": toNumber,
        "body": "Test",
        "from": "+61472880742"

    };
    request.onreadystatechange = function () {
        // ev.preventDefault();
        if (request.status == 200 && request.readyState == 4) {
            alert("Success!");
        } else {
            console.log("Failed sending sms");
            console.log(request.status);
        }
    };
    request.send(params);
}

function test() {
    $.ajax({
        url: 'https://tapi.telstra.com/v2/messages/provisioning/subscriptions',
        type: 'POST',
        dataType: 'json',
        data: {
            "activeDays": 30,
            "notifyURL": "http://abcd.com",
            "callbackData":
                {
                    "anything": "abc"
                }
        },
        async: true,

        success: function (data, status) {
            console.log(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            alert("Status: " + textStatus);
            alert("Error: " + errorThrown);
            // alert("Error");
            // window.location.href = '{{ path('signin') }}';
        }
    });
}
