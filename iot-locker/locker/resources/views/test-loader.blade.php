<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .content {
            display: none;
        }

        /* .loader {
            background: #000;
            width: 100vw;
            height: 100vh;
            position: fixed;
            z-index: 100;
            opacity: 0.8;
            display: grid;
            place-content: center;
        } */


        .loader {
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background-color: lightblue;
            position: absolute;
        }

        .loader>div {
            height: 100px;
            width: 100px;
            border: 15px solid #45474b;
            border-top-color: #2a88e6;
            position: absolute;
            margin: auto;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 50%;
            animation: spin 1.5s infinite linear;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div class="loader">
        <div></div>
        <!-- <img src="{{ asset('') }}assets/images/loader.gif" alt=""> -->
    </div>
    <div class="content">
        <!-- The grid: four columns -->
        <div class="row">
            <div class="column">
                <img src="{{ asset('') }}assets/images/bg/home-bg.jpg" alt="Nature" onclick="myFunction(this);">
            </div>
            <div class="column">
                <img src="{{ asset('') }}assets/images/bg/home-bg-1.jpg" alt="Snow" onclick="myFunction(this);">
            </div>
            <div class="column">
                <img src="{{ asset('') }}assets/images/bg/home-bg-2.jpg" alt="Mountains" onclick="myFunction(this);">
            </div>
            <div class="column">
                <img src="{{ asset('') }}assets/images/bg/home-bg-3.jpg" alt="Lights" onclick="myFunction(this);">
            </div>
            <div class="column">
                <img src="{{ asset('') }}assets/images/bg/home-bg-4.jpg" alt="Lights" onclick="myFunction(this);">
            </div>
            <div class="column">
                <img src="{{ asset('') }}assets/images/bg/home-bg-5.jpg" alt="Lights" onclick="myFunction(this);">
            </div>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(window).load('load', function() {
            $('.loader').fadeOut(1000);
            $('.content').fadeIn(1000);
        });
    </script>
</body>

</html>