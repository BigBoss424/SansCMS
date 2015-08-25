<!DOCTYPE html>

<html>
<head>

	<meta charset="utf-8" />
	
	<title><?php echo $message[$code] ?></title>

	<style>
	
		/*--FONTS--*/
				
		@import url(http://fonts.googleapis.com/css?family=Cabin);
		
		/*--RESET--*/
		
		* {
			margin: 0;
			padding: 0;
			border: none;
			outline: none;
			font: inherit;
			color: inherit;
			line-height: inherit;
			vertical-align: baseline;
			
			-webkit-box-sizing: border-box;
			   -moz-box-sizing: border-box;
			        box-sizing: border-box;
			
			-webkit-font-smoothing: antialiased;
			   -moz-font-smoothing: antialiased;
			        font-smoothing: antialiased;
		}
		
		html, body {
			min-height: 100%;
			width: 100%;
			position: absolute;
		}
		
		/*--BODY--*/
		
		body {
			font: normal 400 44px/125% "Cabin", "Helvetica Neue", Helvetica, Arial, sans-serif;
			background: #111 url('<?php print HTTP ?>assets/img/error.gif') no-repeat center center;
			
			-webkit-background-size: cover;
			   -moz-background-size: cover;
			        background-size: cover;
		}
		
		body:before {
			content: '';
			height: 100%;
			width: 100%;
			top: 0;
			right: 0;
			bottom: 0;
			left: 0;
			background: #111;
			position: absolute;
			opacity: .65;
		}
		
		a {
			top: 50%;
			left: 50%;
			width: 85%;
			text-align: center;
			color: #fff;
			text-decoration: none;
			position: absolute;
			
			-webkit-transform: translateY(-50%) translateX(-50%);
			   -moz-transform: translateY(-50%) translateX(-50%);
			    -ms-transform: translateY(-50%) translateX(-50%);
			        transform: translateY(-50%) translateX(-50%);
		}
		
		@media (max-width: 640px) {
			
			body {
				font-size: 32px;
			}
			
		}
		
	</style>

</head>

<body>

	<a href="/"><?php echo $message[$code] ?></a>

</body>
</html>