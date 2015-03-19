    </div><!-- #main -->	   
</div><!-- #wrapper -->
<div id="footer">
    <div id="bottomNavigation">
        <a href="<?php echo get_site_url( $blog_id = null, $path = 'our-roasts', $scheme = null ); ?>" id="roastsLink" class="navLinks">
              <h1><?php $post_type = get_post_type_object('bbr_roasts'); echo $post_type->label ; ?></h1>
        </a>
        <a href="<?php echo get_site_url( $blog_id = null, $path = 'our-videos', $scheme = null ); ?>" id="videoLink" class="navLinks">
              <h1><?php $post_type = get_post_type_object('videos'); echo $post_type->label ; ?></h1>
        </a>
        <a href="<?php echo get_site_url( $blog_id = null, $path = 'our-favorites', $scheme = null ); ?>" id="favLink" class="navLinks">
              <h1><?php $post_type = get_post_type_object('favorites'); echo $post_type->label ; ?></h1>
        </a>
        <a href="<?php echo get_site_url( $blog_id = null, $path = 'our-quality', $scheme = null ); ?>" id="passionLink" class="navLinks" style="margin-right:0">
              <h1><?php $post_type = get_post_type_object('passion'); echo $post_type->label ; ?></h1>
        </a>
    </div><!-- #bottonNavigation --> 
    <div id="footerHoverBox">
    	<div class="hoverBlock transparify roastHover"></div> 
        <div class="hoverBlock transparify videoHover"></div> 
        <div class="hoverBlock transparify favHover"></div> 
        <div class="hoverBlock transparify passionHover"></div> 
    </div>  
        <div id="footerBanner">
			<div id="colophon">
            	<div id="site-info">
                	<div id="seeMore">+ SEE MORE</div>
                	<div class="copyright">&copy;<?php echo date("Y"); ?> Brooklyn Beans Roastery</div>
                </div><!-- #site-info -->
                <div id="belowTheFooter">
                	<div class="footerCol" style="width:164px; padding-left:5px;">    	
                    <a href="http://www.facebook.com/BrooklynBeanRoastery" target="_blank"><div class="footerIcon facebookIcon"><span>Facebook</span></div></a>
                    <a href="https://twitter.com/BrooklynBeans1" target="_blank"><div class="footerIcon twitterIcon"><span>Twitter</span></div></a>
                    <a href="http://www.flickr.com/photos/brooklynbeans" target="_blank"><div class="footerIcon flickrIcon"><span>Flickr</span></div></a>
                    <!--<div class="footerIcon googleIcon"><span>Google+</span></div>-->
                    <a href="http://pinterest.com/brooklynbeans/" target="_blank"><div class="footerIcon pinterestIcon"><span>Pinterest</span></div></a>
                    </div>
                	<div class="footerCol">    	
                    <span class="footerTitle"><a href="https://www.facebook.com/BrooklynBeanRoastery/app_228910107186452" target="_blank">WIN FREE STUFF!</a></span><br />
					Log onto Facebook to enter the latest contest
                    </div>
                    <div class="footerCol">    	
                    <span class="footerTitle"><a href="https://www.facebook.com/BrooklynBeanRoastery/app_100265896690345" target="_blank">SUBSCRIBE!</a></span><br />
                    <span style="font-size:13px;">Stay up to date on all the new products a promotions with the monthly BBR newsletter.</span>
                    </div>
                    <div class="footerCol">    	
                    <!--<a href="#">Sitemap</a> <br />-->
                    <a href="<?php echo get_site_url(); ?>/contact">Contact Us</a><br />
                    <a href="<?php echo get_site_url(); ?>/ambassador-login">Ambassador Login</a><br />
                    <a href="<?php echo get_site_url(); ?>/faq">FAQ</a><br />
                </div>
                    
                </div>
                <div style="clear:both;"></div>
 			</div><!-- #colophon -->
        </div>
	      <?php wp_footer(); ?>  
</div><!-- #footer -->
<script>
jQuery(document).ready(function($) {
	$('.page_item').hover(
		  function() {
			  $(this).find('ul.children').slideDown('fast');
		  },
		  function() {
			  $(this).find('ul.children').slideUp('fast');
		  }
	  );
	 // Add train icons
	 $("#access li a:contains('BBR')").addClass('A_Train');
	 $("#access li a:contains('Feedback')").addClass('F_Train');
	 $("#access li a:contains('What’s Happening')").addClass('J_Train');
	 $(".menu li a:contains('Get Your BBR')").addClass('L_Train');
	 $(".menu li a:contains('BB Blog')").addClass('Q_Train');
	 $(".menu li a:contains('Contact')").addClass('One_Train');

	 //Closes feedback box
	 $('.closeFeedbackSuccess').click(function(){
	 	$('.feedbackSuccessBg').css('display','none');
	 });
	
	// Controls footer initial animation
	var url = location.pathname;	
	if(url != "/") {
		$('#footer').css('background-position', '0 0');	
		$('.hoverBlock').css('background', '#000000');
		$('#bottomNavigation').delay(800).animate({
		  top: '+=0',
		}, 1000);
		$('#footer').delay(800).animate({
		  height: '54px',
		}, 1000);
		$('#footerBanner').delay(800).animate({
		  top: '-70',
		}, 1000);
	}
	var url = location.pathname;
	//url = url.replace("/beta/", ""); //Remove when pushed to prod
		$('#roastsLink').hover(
		  function() {
		  if(url !=  "/") {
				  $(this).animate({
					  top: '-70'
				  }, 200);
				  $('.roastHover').slideDown('fast');
				  $(this).find('h1').css('color','#f7ba00');
		  }
		  else {
		  		$('.roastHover').slideDown('fast');
				 $(this).find('h1').css('color', '#f7ba00');
		  }
		  },
		  function() {
			  $('.roastHover').slideUp('fast');
			  $(this).animate({
					  top: '0'
				  }, 200);
			  if(url !=  "/") {
				  $(this).find('h1').css('color','#e4e1d5');
			  }
			  else {
			  $(this).find('h1').css('color','#E4E1D5');
			  }
		  }
		);
	  
	  $('#videoLink').hover(
		  function() {
		  if(url !=  "/") {
				  $(this).animate({
					  top: '-70'
				  }, 200);
				  $('.videoHover').slideDown('fast');
				  $(this).find('h1').css('color','#f7ba00');
		  }
		  else {
				  $('.videoHover').slideDown('fast');
				  $(this).find('h1').css('color','#f7ba00');
		  }
		  },
		  function() {
			  $(this).animate({
					  top: '0'
				  }, 200);
			  $('.videoHover').slideUp('fast');
			  if(url !=  "/") {
				$(this).find('h1').css('color','#e4e1d5');
			  }
			  else {
			  	$(this).find('h1').css('color','#E4E1D5');
			  }
		  }
	  );
	  
	  $('#favLink').hover(
		  function() {
		  if(url !=  "/") {
				  $(this).addClass('favLink_Brown');
				  $(this).animate({
					  top: '-70'
				  }, 200);
				  $('.favHover').slideDown('fast');
				 	$(this).find('h1').css('color','#f7ba00');
		  }
		  else {
				  $('.favHover').slideDown('fast');
				  $(this).find('h1').css('color','#f7ba00');
		  }
		  },
		  function() {
			  $(this).animate({
					  top: '0'
				  }, 200);
			  $('.favHover').slideUp('fast');
			  if(url.search("page_id") > 0) {
				  $(this).find('h1').css('color','#e4e1d5');
			  }
			  else {
			  	$(this).find('h1').css('color','#E4E1D5');
			  }
		  }
	  );
	  
	  $('#passionLink').hover(
		  function() {
		  if(url !=  "/") {
				  $(this).animate({
					  top: '-70'
				  }, 200);
				  $('.passionHover').slideDown('fast');
				  $(this).find('h1').css('color','#f7ba00');
		  }
		  else {
				  $('.passionHover').slideDown('fast');
				  $(this).find('h1').css('color','#f7ba00');
		  }
		  },
		  function() {
			  $(this).animate({
					  top: '0'
				  }, 200);
			  $('.passionHover').slideUp('fast');
			  if(url !=  "/") {
				  $(this).find('h1').css('color','#e4e1d5');
			  }
			  else {
			  	$(this).find('h1').css('color','#E4E1D5');
			  }
		  }
	  );
//Changes roasts thumb images
$('.roastBox').hover(
	function(){
		$(this).find('img').css('top','-100px');
		$(this).find('p').css('color', '#f7ba00');
	},
	function() {
		$(this).find('img').css('top','0');
		$(this).find('p').css('color', '#e4e1d5');
	}
);

 // Hover for favorites
 $('div.enlarge').hover(
  	function(){
		$(this).css('z-index','1000');
		
		$(this).find('img').animate({
			  width: '200px',
			  height: '200px',
			  left: '-10px'
	 	}, 75, function() {
			var caption = $(this).parent().find('img').attr('alt');
			$(this).parent().append("<div class='hoverDescription'>"+caption+"</div>");
			$('.hoverDescription').slideDown(50);
			});
	
	},
	
	//Hover Out
	function(){
		$(this).find('img').animate({
			  width: '170px',
			  height: '170px',
			  left: '0'
	 	}, 75);
	$(this).css('z-index','100');
	$('.hoverDescription').remove();
	});
	
  	//Footer expansion
	$("#seeMore").toggle(function(){
	$("#seeMore").text("- SEE LESS");
	var url = location.pathname;
	//url = url.replace("/beta/", ""); //Remove when pushed to prod
	if(url !=  "/") {
  		$('#footerBanner').animate({top:'-180px'},200);
	}
	else {
		$('#footerBanner').animate({top:'-110px'},200);
	}
	},function(){
	$("#seeMore").text("+ SEE MORE");
	if(url !=  "/") {
 			$('#footerBanner').animate({top:'-70px'},200);
	}
	else {
		$('#footerBanner').animate({top:'0'},200);
	}
	});	  
});
</script>
<script>
  //analytics
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34593778-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>