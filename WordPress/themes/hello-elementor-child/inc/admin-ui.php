<?php
add_action( 'admin_head', function() {
// Add CSS code below.
?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter+Tight&display=swap" rel="stylesheet">
<style>
	html {--brand-color: #1D4ED8;
	--rounded: 8px;
	--mrounded: 12px}
		
    body, td, textarea, input, select {
      font-family: 'Inter Tight';
    } 

	/* Ocultar itens */
    #menu-comments,
	#toplevel_page_postman,
	.user-admin-color-wrap,
	.user-url-wrap,
	.user-facebook-wrap,
	.user-instagram-wrap,
	.user-linkedin-wrap,
	.user-myspace-wrap,
	.user-pinterest-wrap,
	.user-soundcloud-wrap,
	.user-tumblr-wrap,
	.user-twitter-wrap,
	.user-youtube-wrap,
	.user-wikipedia-wrap,
	.user-profile-picture,
	.ratings-row,
	.show-admin-bar.user-admin-bar-front-wrap,
	.user-language-wrap,
	#application-passwords-section,
	#your-profile > h2:nth-child(10),
	#your-profile > table:nth-child(5),
	ul#adminmenu a.wp-has-current-submenu:after, ul#adminmenu>li.current>a.current:after,
	#collapse-button,
	#adminmenu li.wp-has-submenu.wp-not-current-submenu.opensub:hover:after, #adminmenu li.wp-has-submenu.wp-not-current-submenu:focus-within:after
	{
        display: none;
    }
	
	#adminmenu a:focus, #adminmenu a:hover, .folded #adminmenu .wp-submenu-head:hover {
		box-shadow: none;
	}

.avatar, .notice {
	border-radius: var(--rounded);
}

input {
	border-radius: var(--rounded);
	padding: 5px 15px;
}

  #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
    background: #222222;
    margin: 5px;
    padding: 0;
    color: white;
    background-color: #2272b1;
    border-radius: var(--rounded);
    padding-top: 3px;
    padding-bottom: 3px;
    margin-right: 0.5rem;
    align-items: center;
}

	#adminmenu a.menu-top {
    background-color: transparent;
    border-radius: var(--rounded);
    padding-top: 0.2rem;
    padding-bottom: 0.2rem;
    margin-right: 0.5rem;
    align-items: center;
    margin-left: 0.5rem;
	}
	
	#adminmenuwrap, #adminmenuback {
		width: 210px;
	}
	#adminmenu {
		width: 190px;
		margin-left: 10px;
		margin-right: 15px;
	}
	#wpcontent {
		margin-left: 210px;
	}
	#adminmenu > li.wp-menu-open > ul.wp-submenu {
		background-color: transparent !important;
	}
	#adminmenu .wp-submenu {
		border-radius: var(--rounded);
		left: 190px;
	}
	#adminmenu li a:focus div.wp-menu-image:before, #adminmenu li.opensub div.wp-menu-image:before, #adminmenu li:hover div.wp-menu-image:before { 
		color: white;
	}
	.wp-menu-name {
		font-size: 12px;
	}
	.wp-menu-name, #adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover, #adminmenu a:hover, #adminmenu li.menu-top>a:focus {
		color: white;
	}
	
	#adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus {
	background-color: #edeeff11;
	}
	#adminmenu li.menu-top:hover, #adminmenu li.opensub>a.menu-top, #adminmenu li>a.menu-top:focus {
    color: var(--brand-color);
}
	
	.wp-list-table, #wpadminbar .menupop .ab-sub-wrapper, #wpadminbar .shortlink-input {
		border-radius: var(--rounded);
	}
	
	.stuffbox {
		border-radius: var(--mrounded);
		border: none;
		overflow: hidden;
	}
	
	.notice, div.error, div.updated {
		border-color: #05050505;
		border-width: 1px;
	}
	
	.notice-success, div.updated {
    background-color: #EDFFF2;
}
	
	.notice-warning {
		background-color: #FFFAED;
	}
	
	.notice-info {
		background-color: #EDF6FF;
	}
	
	.notice-dismiss:before {
		transition: color 0.3s ease;
	}
	
	button {
		transition: background 0.3s linear;
		border-radius: var(--rounded);
	}
	
	.wp-editor-container {
    border-radius: var(--mrounded);
    overflow: hidden;
}
	
	.widefat td, .widefat th {
    padding: 15px 10px; 
	}
	.wp-core-ui select, input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea, .wp-core-ui .button, .wp-core-ui .button-primary, .wp-core-ui .button-secondary, .wrap .add-new-h2, .wrap .add-new-h2:active, .wrap .page-title-action, .wrap .page-title-action:active {
		border-radius: 6px;
		border-color: #f1f1f1;
	}
	body {
		background: #ffffff;
	}
	
	/* Acaba aqui */
}
   </style>
<?php
	});