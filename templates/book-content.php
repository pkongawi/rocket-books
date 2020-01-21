<?php 
//if this file is called directly, ablort.

if ( ! defined( 'ABSPATH' ) ){
    die;
}
?>


<div class="book-content" style="background-color: lightskyblue;">
    
    <?php echo get_the_content(); ?>
    
</div>