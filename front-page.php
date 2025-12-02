<?php
/**
 * Front page template.
 *
 * @package Tenores
 */

get_header();
?>

<div class="bg-dark text-light">
    <?php
    get_template_part('template-parts/home/hero');
    get_template_part('template-parts/home/webinar-banner');
    get_template_part('template-parts/home/voice-gold');
    get_template_part('template-parts/home/benefits');
    get_template_part('template-parts/home/testimonial');
    get_template_part('template-parts/home/offer');
    get_template_part('template-parts/home/articles');
    ?>
</div>

<?php
get_footer();


