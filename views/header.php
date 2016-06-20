<!doctype html>
<html>
	<head>
		<title>Testimeter</title>
		<link rel="stylesheet" href="<?php echo URL; ?>public/css/style.css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo URL; ?>public/js/custom.js"></script>
		<?php
			if (isset($this->js)) 
			{
				foreach ($this->js as $js)
				{
					echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
				}
			}
		?>
	</head>
	<body>
		<?php Session::init(); ?>
		<section id="menubar">
		</section>
		<header>
			<ul>
				<li><a href="https://www.hs-flensburg.de/"> <img src="images/HS.png"/> </a></li> 
			</ul>
			<h1>Testimeter</h1>
		</header>
		<nav class="nav">
			<ul>
				<?php if (Session::get('loggedIn') == false):?>
					<li><a href="<?php echo URL; ?>index">Index</a></li>
					<li><a href="<?php echo URL; ?>help">Help</a></li>
				<?php endif; ?>	
				<?php if (Session::get('loggedIn') == true):?>
					<li><a href="<?php echo URL; ?>dashboard">Dashboard</a></li>
		
				<?php if (Session::get('ROLE') == 'Administrator'):?>
					<li><a href="<?php echo URL; ?>user">Users</a></li>
				<?php endif; ?>
		
					<li><a href="<?php echo URL; ?>dashboard/logout">Logout</a></li>	
				<?php else: ?>
					<li><a href="<?php echo URL; ?>login">Login</a></li>
				<?php endif; ?>
			</ul>
		</nav>
		<section id="main">
			<article>
