<!DOCTYPE html>
<html>
<head>
  <title>Soleful</title>  
  <style>
    @media (max-width: 350px) {
        .header-right {
            font-size: 80%;
        }
    }
    @media (max-width: 600px) {
        div[style*="width: 700px"] {
            width: 100% !important;
        }
        .header-right {
            position: static !important;
            text-align: left !important;
            padding: 10px 0 !important;
        }
        table {
            width: 100% !important;
        }
        td, th {
            display: block;
            text-align: left !important;
            width: 100% !important;
        }
    }
  </style>
</head>
<body style="background: #EEE; font-family: sans-serif; padding:0px;margin:0px;min-height:100vh;color:#333;line-height:150%; font-size:16px;">
    <div style="width: 700px; margin: 0px auto; background:#FFF; min-height:100vh;position:relative;">
        <div style="text-align: left;background:#FFF; padding:5px 15px; height:75px; border-bottom:1px solid #df9b19; background:#df9b19;">
            <div style="max-width:50%;clear:none;float:left;">
                <img src="{{url('assets/img/logo/logo.png')}}" style="height:auto; margin-top:-3px; max-width:100%;" alt="Soleful" />
            </div>
            <div style="float:right;text-align:right;padding:10px 0;white-space:normal;position:absolute; right:10px; top:15px; z-index:25;" class="header-right">
                <img src="{{ url('assets/img/ph.png') }}" width="14" height="14"> <a href="tel:+917996666225" style="color:#FFF;font-weight:bold;text-decoration:none;">+91 79966 66225</a><br/>
                <img src="{{ url('assets/img/em.png') }}" width="14" height="14"> <a href="mailto:relationship@soleful.in" style="color:#FFF;font-weight:bold;text-decoration:none;">relationship@soleful.in</a>
            </div>
        </div>
        <div style="padding:15px 25px; letter-spacing:0px;min-height: calc(100vh - 215px);clear:both;">
            @yield('content')
        </div>
        <div style="background:#333;min-height:20px;padding:10px 0;">
            <div style="text-align:center;color:#FFF;">
                <p style="margin-bottom:5px;"><span style="font-style:italic;">Visit-</span> 
                    <a href="https://www.soleful.in" style="color:#FFF;">soleful.in</a>
                </p>
            </div>
        </div>
    </div>
   
</body>
</html>