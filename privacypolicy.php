<?php

require 'authentication.php'; // admin authentication check 
include('config.php');

$page_name="privacypolicy";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Privacy Policy - In5nite VR</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker.css">
	<link rel="stylesheet" href="assets/bootstrap-datepicker/css/datepicker-custom.css">
	<link rel="stylesheet" href="assets/jquery-ui-1.13.0/jquery-ui.css">
	<link rel="stylesheet" href="Demo%20SciUI_files/toastr.css" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/custom.css">
	<!--<link href="Demo%20SciUI_files/grid.css" rel="stylesheet" type="text/css">-->
	<link href="Demo%20SciUI_files/styles.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--<link rel="stylesheet" type="text/css" href="TimeCircles.css">-->
	<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<!--<script src="assets/js/custom.js"></script>-->
	<script src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script src="assets/bootstrap-datepicker/js/datepicker-custom.js"></script>
	<script src="Demo%20SciUI_files/jquery_002.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/toastr.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/howler.js" crossorigin="anonymous"></script>
	<script src="Demo%20SciUI_files/jquery.js"></script>
	<script src="Demo%20SciUI_files/progressbar.js"></script>
	<!--<script type="text/javascript" src="TimeCircles.js"></script>-->
	<!--<script src="Demo%20SciUI_files/base.js" crossorigin="anonymous"></script>-->
    <link rel="icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-180x180.png" />
    <meta name="msapplication-TileImage" content="https://www.vdream.co.in/wp-content/uploads/2021/08/cropped-VDREAM-01-1-270x270.png" />
    <script type="text/javascript">
        /* delete function confirmation  */
        function check_delete() {
        var check = confirm('Are you sure you want to delete this?');
            if (check) {
                return true;
            } else {
                return false;
            }
        }
        
        var sound = new Howl({
        src: ['./audio/buzz_blink.wav']
        });
        var sound0 = new Howl({
        src: ['./audio/Docs1.wav']
        });
        var sound1 = new Howl({
        src: ['./audio/Docs2.wav']
        });
        var sound2 = new Howl({
        src: ['./audio/Docs3.wav']
        });
        var sound3 = new Howl({
        src: ['./audio/Docs4.wav']
        });
        var sound4 = new Howl({
        src: ['./audio/Docs5.wav']
        });
        var sound5 = new Howl({
        src: ['./audio/Docs6.wav']
        });
        var sound6 = new Howl({
        src: ['./audio/Docs7.wav']
        });
        
        sound.play();
    </script>
	<style>
        td {
            vertical-align:CENTER;
            text-align: center;
        }
        .mode-color{
            background-color: #152a3b;
            border: 1px solid rgba(34,69,97,0.4);
        }
        a,
        a:hover{
        text-decoration: none;
        }
        ul.ui-autocomplete {
            z-index: 1100;
        }
	</style>
</head>
<body>
	<div class="panel shown" style="padding:50px;">
		<a href="registration.php" style="font-size:32px;">IN<span class="alert" style="margin:0;padding:0;border:0;">5</span>NITE VR</a>
		<a href="registration.php" class="button warning round pull-right" onclick="sound5.play()">Register <span style="margin-top:3px;margin-left:10px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-log-out"></span></a>
	</div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel shown p-4">
				<h1>Privacy Policy for IN5NITE VR</h1>
                <p>At IN5NITE VR, accessible from https://vdream.co.in/in5nite/registeration.php, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by IN5NITE VR and how we use it.</p>
                <p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>
                <h2>Log Files</h2>
                <p>IN5NITE VR follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users' movement on the website, and gathering demographic information. Our Privacy Policy was created with the help of the <a href="https://www.privacypolicyonline.com/privacy-policy-generator/">Privacy Policy Generator</a>.</p>
                <h2>Privacy Policies</h2>
                <P>You may consult this list to find the Privacy Policy for each of the advertising partners of IN5NITE VR.</p>
                <p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on IN5NITE VR, which are sent directly to users' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>
                <p>Note that IN5NITE VR has no access to or control over these cookies that are used by third-party advertisers.</p>
                <h2>Third Party Privacy Policies</h2>
                <p>IN5NITE VR's Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options. </p>
                <p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers' respective websites. What Are Cookies?</p>
                <h2>Children's Information</h2>
                <p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>
                <p>IN5NITE VR does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</p>
                <h2>Online Privacy Policy Only</h2>
                <p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in IN5NITE VR. This policy is not applicable to any information collected offline or via channels other than this website.</p>
                <h2>Consent</h2>
                <p>By using our website, you hereby consent to our Privacy Policy and agree to its Terms and Conditions.</p>
			</div>
		</div>
	</div>
</body>
</html>