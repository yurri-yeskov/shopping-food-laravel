<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>Local Fine Foods</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

    <link rel="stylesheet" href="{{URL::asset('/css/bootstrap.min.css')}}" />
    <!-- <link rel="stylesheet" href="css/style.css" /> -->

    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto');
        body{font-family: "Roboto";}
      .thnx-block img {	max-width: 66px;	display: block;	margin: 0 auto;	width: 100%;}
      .thnx-block {	text-align: center;	padding: 40px;	box-shadow: 0px 0px 10px #ccc;	max-width: 800px;	margin: 50px auto;}
      .thnx-block p {	margin-top: 20px;	color: #202020;	line-height: 1.6rem;}
      .common-section {	position: absolute;	width: 100%;	left: 50%;	top: 50%;	transform: translate(-50%,-50%);}
      .thnx-block a {	margin-top: 60px;	display: block;	color: #202020;}
      .thnx-block a:hover{color: #ff3800;}
    </style>

</head>

<body>

    <div class="common-section">

	@if($status=="CM")


    <div class="driverStep wrapper thnx-page succes-page">
      <div class="container">
          <div class="row">
              <div class="col-lg-12 col-md-12">
                  <div class="formContent bg-white ">
                      <div class="thnx-block">
                          <img src="{{URL::asset('/images/successful-icon.svg')}}" alt="">
                          <h3>Transaction Successful</h3>
                          <p>Amount has been added to your Rigo wallet</p>
                          {{-- <a href="home.html">Back</a> --}}
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>

@else

    <div class="driverStep wrapper thnx-page succes-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="formContent bg-white ">
                        <div class="thnx-block">
                            <img src="{{URL::asset('/images/failed.svg')}}" alt="">
                            <h3>Payment failed</h3>
                            {{-- <a href="home.html">Back</a> --}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endif


</div>

</body>

</html>