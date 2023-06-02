<?php
/*
Plugin Name: Advertisement Content
Plugin URI: https://github.com/valentinzamarin/wp-advertisement-content
Description:
Version: 1.0
Author: Valentin Zamarin
*/

class Advertisement {

    public function __construct() {
        add_filter('the_content', [$this, 'insert_advertisement']);
    }

    public function advertisement_code( int $id ) {
        $ads_code = '';

        if (is_single() && wp_is_mobile()) :
            $ads_code = '<div>mobile ads</div>';
        elseif( is_single() && !wp_is_mobile() ) :
            $ads_code = '<div>desktop ads</div>';
        endif;

        return $ads_code;
    }

    public function insert_advertisement(string $content): string {
        $post_id = get_the_ID();

        $content_array = [];

        $closing_p = '</p>';
        $paragraphs = explode($closing_p, $content );
        $middle = floor(count($paragraphs) / 2);

        $count = 1;

        foreach ($paragraphs as $idx => $paragraph) :
            $pos = strpos($paragraph, '<blockquote>');
            if (
                $pos !== false
            ) :
                $paragraph = $paragraph . '<div style="display: none">blockquote</div>';;
                $content_array[] = $paragraph;
            else :
                if( $middle >= 7 && $idx == $count ) :
                    $paragraph = $paragraph;
                    $paragraph .= $this->advertisement_code( $post_id );
                elseif( $idx == 1 && $middle < 7 ) :
                    $paragraph = $paragraph;
                    $paragraph .= $this->advertisement_code( $post_id );
                else :
                    $paragraph = $paragraph;
                endif;
                $content_array[] = $paragraph;
                $count++;
            endif;
        endforeach;

        return implode('', $content_array);
    }
}

new Advertisement();

