<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage Brickbox
 * @since Brickbox 1.0
 */

get_header(); ?>
<div id="search-container" class="search-box-wrapper hide">
			<div class="search-box">
				<?php get_search_form(); ?>
			</div>
		</div>
</header><!-- #masthead -->

	<div id="main" class="site-main">
<?php
echo do_shortcode('[smartslider2 slider="1"]');
?>


<ul class="gridBox">
<a href="http://esztercoughlaninterior.dev:8888/interior-design-consultancy/"><li class="largeBox" id="InteriorDesignConsultancy"><span class="boxSpan">Interior Design Consultancy</span></li></a>
<a href="http://esztercoughlaninterior.dev:8888/our-packages/"><li class="medBox" id="OurPackages"><span class="boxSpan">Our Packages</span></li></a>
<a href="http://esztercoughlaninterior.dev:8888/booking/"><li class="smallBox" id="Booking"><span class="boxSpan">Book an appointment</span></li></a>
<a href="http://esztercoughlaninterior.dev:8888/about-us/"><li class="smallBox" id="AboutUs"><span class="boxSpan">About us</span></li></a>
<a href="http://esztercoughlaninterior.dev:8888/home-design-blog/"><li class="medBox" id="HomeDesignBlog"><span class="boxSpan">Home Design Blog</span></li></a>
</ul>

<section class="rightBox">
<h2>Find me on...</h2>
<ul id="socialIcons">
<li id="polyvore">&nbsp;</li>
<li id="twitter">&nbsp;</li>
<li id="facebook">&nbsp;</li>
<li id="tumblr">&nbsp;</li>
</ul>
</section>
	
<?php
get_footer();
