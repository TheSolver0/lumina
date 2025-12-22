<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from wpkixx.com/html/pitnik/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 17 Oct 2020 22:27:41 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
	<title>LUMINA</title>
    <link rel="icon" href="{{ asset('assets/images/ico.png') }}" type="image/png" sizes="16x16"> 
    
    <link rel="stylesheet" href="{{ asset('assets/css/main.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/weather-icons.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/toast-notification.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/page-tour.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/icofont.min.css') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>



</head>
<body>
<div class="wavy-wraper">
		<div class="wavy">
		  <span style="--i:1;">l</span>
		  <span style="--i:2;">u</span>
		  <span style="--i:3;">m</span>
		  <span style="--i:4;">i</span>
		  <span style="--i:5;">n</span>
		  <span style="--i:6;">a</span>
		  <span style="--i:7;">.</span>
		  <span style="--i:8;">.</span>
		  <span style="--i:9;">.</span>
		</div>
	</div>
<div class="theme-layout">
	
	<div class="postoverlay"></div>
	
	<div class="responsive-header">
		<div class="mh-head first Sticky">
			<span class="mh-btns-left">
				<a class="" href="#menu"><i class="fa fa-align-justify"></i></a>
			</span>
			<span class="mh-text">
				<a href="newsfeed.html" title=""><img src="{{ asset('assets/images/logo-6.png') }}" alt=""></a>
			</span>
			<span class="mh-btns-right">
				<a class="fa fa-sliders" href="#shoppingbag"></a>
			</span>
		</div>
		<div class="mh-head second">
			<form class="mh-form">
				<input placeholder="search" />
				<a href="#/" class="fa fa-search"></a>
			</form>
		</div>
		
		
	</div><!-- responsive header -->
	
	<div class="topbar stick">
		<div class="logo">
			<a title="" href="newsfeed.html"><img src="{{ asset('assets/images/logo-6.png') }}" class="logo" alt=""></a>
		</div>
		<div class="top-area">
			<div class="main-menu">
				<span>
			    	<!-- <i class="fa fa-braille"></i> -->
			    </span>
			</div>
			<div class="top-search">
				<form method="post" class="">
					<input type="text" placeholder="Search People, Pages, Groups etc">
					<button data-ripple><i class="ti-search"></i></button>
				</form>
			</div>
			<div class="page-name">
			    <span>Accueil</span>
			 </div>
			<ul class="setting-area">
				<li><a href="newsfeed.html" title="Home" data-ripple=""><i class="fa fa-home"></i></a></li>
				
				
				
				<li><a href="#" title="Help" data-ripple=""><i class="fa fa-question-circle"></i></a>
					<div class="dropdowns helps">
						<span>Quick Help</span>
						<!-- <form method="post">
							<input type="text" placeholder="How can we help you?">
						</form> -->
						<span>Help with this page</span>
						<ul class="help-drop">
							<li><a href="forum.html" title=""><i class="fa fa-book"></i>Community & Forum</a></li>
							<li><a href="faq.html" title=""><i class="fa fa-question-circle-o"></i>FAQs</a></li>
							<li><a href="career.html" title=""><i class="fa fa-building-o"></i>Carrers</a></li>
							<li><a href="privacy.html" title=""><i class="fa fa-pencil-square-o"></i>Terms & Policy</a></li>
							<li><a href="#" title=""><i class="fa fa-map-marker"></i>Contact</a></li>
							<li><a href="#" title=""><i class="fa fa-exclamation-triangle"></i>Report a Problem</a></li>
						</ul>
					</div>
				</li>
			</ul>
			<div class="user-img">
				@if (Auth::user())
					<h5>{{ Auth::user()->name }}</h5>
				@else
					<h5></h5>
				@endif
				{{-- <h5>Jack Carter</h5> --}}
				<img src="{{ asset('assets/images/resources/admin.jpg') }}" alt="" class="pp">
				<span class="status f-online"></span>
				<div class="user-setting">
					
					<span class="seting-title">User setting <a href="#" title="">see all</a></span>
					<ul class="log-out">
						<li><a href="about.html" title=""><i class="ti-user"></i> view profile</a></li>
						<li><a href="setting.html" title=""><i class="ti-pencil-alt"></i>edit profile</a></li>
						<li><a href="#" title=""><i class="ti-target"></i>activity log</a></li>
						<li><a href="setting.html" title=""><i class="ti-settings"></i>account setting</a></li>
						<li><a href="logout.html" title=""><i class="ti-power-off"></i>log out</a></li>
					</ul>
				</div>
			</div>
			<!-- <span class="ti-settings main-menu" data-ripple=""></span> -->
		</div>
		<!-- nav menu -->
	</div><!-- topbar -->
	
	<div class="fixed-sidebar right">
		<div class="chat-friendz">
			<ul class="chat-users">
				<li>
					<div class="author-thmb">
						<img src="{{ asset('assets/images/resources/Logo-Facsciences-1024x1024-2.jpeg') }}" alt="" title="Faculte des Sciences">
						<!-- <span class="status f-online"></span> -->
					</div>
				</li>
				<li>
					<div class="author-thmb">
						<img src="{{ asset('assets/images/resources/Logo-Facsciences-1024x1024-2.jpeg') }}" alt="" title="Faculte des Lettres">
						<!-- <span class="status f-away"></span> -->
					</div>
				</li>
				
			</ul>
			
		</div>
	</div><!-- right sidebar user chat -->
	
	<div class="fixed-sidebar left">
		<div class="menu-left">
			<ul class="left-menu">
				
				
				
				<li>
					<a href="forum.html" title="Forum" data-toggle="tooltip" data-placement="right">
						<i class="fa fa-forumbee"></i>
					</a>
				</li>
				
				<li>
					<a href="fav-page.html" title="Articles Favoris" data-toggle="tooltip" data-placement="right">
						<i class="fa fa-star-o"></i>
					</a>
				</li>
				
				
				
				<li>
					<a href="support-and-help.html" title="Help" data-toggle="tooltip" data-placement="right">
						<i class="fa fa-question-circle-o">
						</i>
					</a>
				</li>
				<li>
					<a href="faq.html" title="Faq's" data-toggle="tooltip" data-placement="right">
						<i class="ti-light-bulb"></i>
					</a>
				</li>
			</ul>
		</div>
		
	</div><!-- left sidebar menu -->
		