<?php 
/*
Template Name: Honorary Brooklynite Page
*/
?>
<?php get_header(); ?>
 		
        <div class="flatPage brooklynite">
                
<?php the_post(); ?>
 
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-content">
						          <?php the_content(); ?>      
                    </div><!-- .entry-content -->
                     <p class="privacyPolicy"><a target="_blank" href="<?php echo get_site_url( $blog_id = null, $path = 'privacy-policy', $scheme = null ); ?>">Privacy Policy</a></p>
                </div><!-- #post-<?php the_ID(); ?> -->           
 
 				</div><!--.flatPage -->
            </div><!-- #content -->
          </div><!-- #container -->

<script>
    jQuery(document).ready(function($) {
         // moves the last two paragraphs above the submit button
        var lastPar = $('.brooklynite .entry-content p').last();
        var secToLastPar = $('.brooklynite .entry-content p:nth-last-child(2)');
        var fullDisclaimer = '<p class="formSectionTitle">'+secToLastPar.html()+'</p><p>' + lastPar.html() + '</p>';
        $('.brooklynite .entry-content .customcontactform .submit').before(fullDisclaimer); 
        $('.brooklynite .entry-content p').last().remove();
        $(secToLastPar).remove();
        var privacyPol = $('.privacyPolicy');
        $('.entry-content').find('form').after(privacyPol);
        // This next part moves section titles to their spot above labels
        $('.brooklynite .name').prev().before('<p class="formSectionTitle">The Basics</p>');
        $('.brooklynite .how-long ').prev().before('<p class="formSectionTitle">Coffee Time</p>');
        $('.brooklynite .active-blog').first().parent().prev().before('<p class="formSectionTitle">Social Media</p>');
        $('.brooklynite .marriage-status ').first().parent().prev().before('<p class="formSectionTitle">Getting to know you</p>');
        $('.brooklynite .dob-month').parent().before('<p style="margin:20px 0 5px;font-size:18px;">Date of Birth</p>');
        $('.brooklynite .facebook-posts').after('&nbsp;&nbsp;a week');
        $('.brooklynite .tweets').after('&nbsp;&nbsp;a week');
        $('.brooklynite .instagram-posts').after('&nbsp;&nbsp;a week');
        $('.brooklynite .customcontactform').validate({
            // Validation rules (hash keys are input field names)
            rules: {
              hb_name: "required",
              hb_email: { required: true, email: true }, // checks also that the email appears valid
              hb_address: "required",
              hb_city: "required",
              hb_state: "required",
              hb_zip: "required",
              hb_birthday_mo: "required",
              hb_birthday_day: "required",
              hb_birthday_year: "required",
              hb_howlongbeenusing: "required",
              hb_favorite_flavor: "required",
              hb_reg_purchase: "required",
              hb_reg_purchase_where: "required",
              hb_keurig_where: "required",
              hb_brands: "required",
              hb_activeblog: "required",
              hb_facebook_posts: "required",
              hb_tweets: "required",
              hb_instagram_posts: "required",
              hb_marriage_status: "required",
              hb_no_of_children: "required",
              hb_activities: "required",
              hb_website_forwarding: "required",
              hb_no_of_people_emailed_daily: "required",
              hb_other_great_brands: "required",
              hb_past_brand_ambassador: "required",
              hb_why_brand_ambassador: "required" 
            },
            // Error messages for the the validated fields above (if not set, they default to "This field is required")
            messages: {
              hb_name: "Please type your name.",
              hb_email: { required: "Please type your email.", email: "Your email address doesn't appear to be valid" },
              hb_address: "Please provide your address.",
              hb_city: "Please provide your city.",
              hb_state: "Please provide your state.",
              hb_zip: "Please provide your zipcode.",
              hb_birthday_mo: "Please provide the month of your birthday.",
              hb_birthday_day: "Please provide the day of your birthday.",
              hb_birthday_year: "Please provide the year of your birthday.",
              hb_howlongbeenusing: "Let us know how long you have been using Brooklyn Bean products.",
              hb_favorite_flavor: "Tell us your favorite flavor.",
              hb_reg_purchase: "Let us know how you regularly purchase your Brooklyn Bean coffee.",
              hb_reg_purchase_where: "Let us know where you regularly purchase your Brooklyn Bean coffee.",
              hb_keurig_where:"Tell us where you have a Keurig.",
              hb_brands: "Tell us which brands you preferred before Brooklyn Bean.",
              hb_activeblog: "Please ler us know if you have an active blog.",
              hb_facebook_posts: "Type how many times you post to facebook in a week.",
              hb_tweets: "Type how many tweets you make in a week.",
              hb_instagram_posts: "Type how many instagram posts you make in a week.",
              hb_marriage_status: "Let us know if you're married.",
              hb_no_of_children: "Let us know how many children you have.",
              hb_activities: "Click at least one of these.",
              hb_website_forwarding: "Click how many email/websites you forward to friends.",
              hb_no_of_people_emailed_daily: "Click how many people you email daily.",
              hb_other_great_brands: "Please provide a list of other great brands you like.",
              hb_past_brand_ambassador:"Please let us know if you are currently, or have been a past brand ambassador.",
              hb_why_brand_ambassador: "Let us know why you want to be a Brooklyn Bean Ambassador."
            }
        });
    });
</script>           
<?php get_footer(); ?>