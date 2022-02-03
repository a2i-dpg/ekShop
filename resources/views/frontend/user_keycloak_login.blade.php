<html>
<head>
    <link rel="stylesheet" href="{{ static_asset('assests/css/styles.css') }}">
    <script src="https://id.dpg.gov.bd/auth/js/keycloak.js"></script>
    <style>
        .wrap {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .loading{
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .text {
            font-size: 40px;
            color: #fbae17;
            display: inline-block;
            margin-left: 5px;
        }
        @media screen and (max-width: 375px) {
            .text {
                font-size: 35px;
            }
        }
        @media screen and (max-width: 576px) {
            .text {
                font-size: 35px;
            }
        }
        @media screen and (max-width: 768px) {
            .text {
                font-size: 30px;
            }
        }
        @media screen and (max-width: 1024px) {
            .text {
                font-size: 40px;
            }
        }


        .bounceball {
            position: relative;
            display: inline-block;
            height: 37px;
            width: 15px;
        }
        .bounceball:before {
            position: absolute;
            content: '';
            display: block;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #fbae17;
            transform-origin: 50%;
            animation: bounce 500ms alternate infinite ease;
        }

        @keyframes bounce {
            0% {
                top: 30px;
                height: 5px;
                border-radius: 60px 60px 20px 20px;
                transform: scaleX(2);
            }
            35% {
                height: 15px;
                border-radius: 50%;
                transform: scaleX(1);
            }
            50% {
                top: 0;
            }
        }
    </style>
</head>
<body onload="initKeycloak()">


<div id="table-attr">
    <table align="center">

    </table>
</div>
<div d="content" style="width: 20%;">
    <div>
        <div class="wrap">
            <div class="loading">
                <div class="bounceball"></div>
                <div class="text">Please wait we are getting access from </div> <span style="font-size: 40px"><b>identity server</b></span>
            </div>
        </div>
    </div>
</div>

<script>
    var keycloak = new Keycloak();

    function initKeycloak() {

        keycloak.init({onLoad: 'login-required'}).then(function () {
            constructTableRows(keycloak.idTokenParsed);
            pasteToken(keycloak.token);

            let userInfo = keycloak.idTokenParsed
            let xhttp = new XMLHttpRequest();
            xhttp.open("POST", "get-access", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 201) {
                    // Response
                    let response = JSON.parse(this.responseText);
                    let redirectURL = '{{getBaseURL()}}' + 'verification-identity-server-user/' + response.verification_code
                    location.replace(redirectURL);
                }
            };
            var data = {_token: "{{csrf_token()}}", name: userInfo.name, email: userInfo.email, username: userInfo.preferred_username};
            xhttp.send(JSON.stringify(data));

        }).catch(function (e) {
            alert('failed authorization');
        });
    }

    var refreshToken = function () {
        keycloak.updateToken(-1)
            .then(function () {
                document.getElementById('ta-token').value = keycloak.token;
                document.getElementById('ta-refreshToken').value = keycloak.refreshToken;
            });
    }

    var logout = function () {
        keycloak.logout({"redirectUri": '{{getBaseURL()}}' + "logout-identity-server"});
    }
</script>

</body>
</html>
