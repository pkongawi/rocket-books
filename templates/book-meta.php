<?php 
/**  */
?>
    <ul class="book-meta-fields">
    <!-- Here we will display our custom meta -->      
    <?php 
    $meta_fields = array(
    'rbr_book_pages'  => __('Pages', 'rocket-books'),
    'rbr_book_format' => __('Format', 'rocket-books'),
    'rbr_is_featured' => __('is featured', 'rocket-books'),
    );   
    $html = '';
    foreach ( $meta_fields as $meta_key => $label ) {
        //First : meta value
        $value = esc_html( get_post_meta( get_the_ID(), $meta_key, true ) );
        // if its not empty, then we are going to build html
        if (empty($value)){
            continue;
        }
    $html .= "<li>{$label} : $value</li>";
    } 
        echo $html;
    ?>   
    </ul>