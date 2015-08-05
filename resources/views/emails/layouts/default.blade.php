<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>RentGorilla.com</title>
    <style type="text/css">
        #outlook a {padding:0;}
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;font-family:Verdana,Helvetica,sans-serif;}
        h1{color:#73B063;}
        .ExternalClass {width:100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
        #backgroundTable {
            margin:0; padding:0; width:100% !important; line-height: 100% !important;
            background:white;
            border-spacing:5px;
            border-collapse:separate;
        }
        #backgroundTable th {
            background:#73B063;
            padding:15px;
            color:white;
        }
        #backgroundTable th img {
            max-width:90%;
            margin:0 auto;
            height:auto;
        }
        #backgroundTable .half {
            width:46%;
        }
        #content {
            max-width:800px;
            /*width:600px;*/
            min-width:300px;
        }
        #content p {
            font-size:.8em;
        }
        #content img {
            max-width:100%;
        }
        img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        .image_fix {display:block;}
        p {margin: 1em 0;}
        h1, h2, h3, h4, h5, h6 {color: #73B063 !important;}
        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
        h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
            color: red !important;
        }
        h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
            color: purple !important;
        }
        table td {border-collapse: collapse;}
        table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
        a {color: orange;}
        @media only screen and (max-device-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: black;
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }
        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: blue;
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }
        @media only screen and (-webkit-min-device-pixel-ratio: 2) {

        }

        @media only screen and (-webkit-device-pixel-ratio:.75){
        }
        @media only screen and (-webkit-device-pixel-ratio:1){
        }
        @media only screen and (-webkit-device-pixel-ratio:1.5){
        }
    </style>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable">
    <tr><th><img height="100" id="logo" src="http://wedesignvalue.ca/rg/email_images/logo.png" alt="" /></th></tr>
    <tr>
        <td>
            <table id="content" cellpadding="0" cellspacing="0" border="0" align="center" style="margin:0 auto;">
                <tr>
                    <td width="" valign="top">
                        <h1>Hey there, {{ $name or '' }}</h1>
                        <div id="content">
                            <p></p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:15px; background:#E7E7E6;">
                        @yield('body')
                    <p>Thanks for using our service,</p>
                    <p>- The RentGorilla.ca Team</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:5px; background:white;"></td>
                </tr>
            </table>
            <table width="100%">
                <tr id="footer">
                    <td style="background:#4A4A4A; color:white; text-align:center; padding:5px;">
                        &copy; {{ date('Y') }} <a href="https://rentgorilla.ca" style="color:gray;">RentGorilla.ca</a> | All Rights Reserved<br/>
                    </td>
                </tr>
            </table>
    </tr>
</table>
</body>
</html>