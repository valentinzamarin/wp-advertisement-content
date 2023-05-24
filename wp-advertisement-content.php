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
        add_filter('the_content', [$this, 'test_function']);
    }

    public function test_function(string $content): string {
        $post_id = get_the_ID();

        $code = '<div>Нужный кусок</div>';

        $content_array = [];

        $closing_p = '</p>';
        $paragraphs = explode($closing_p, $content );
        $middle = floor(count($paragraphs) / 2);

        foreach ($paragraphs as $idx => $paragraph) :
            $pos = strpos($paragraph, 'blockquote');
            if (
                $pos === false
            ) :
                $paragraph = $paragraph;
                $content_array[] = $paragraph;
            elseif(
                $pos >= 5
            ) :
                $paragraph = $paragraph . '</blockquote>';
                $content_array[] = $paragraph;
            elseif(
                $pos <= 3
            ) :
                $paragraph = str_replace( '<blockquote>', '', $paragraph );
                $paragraph = $paragraph;
                $content_array[] = $paragraph;
            endif;
        endforeach;

        if( $middle >= 7 ) {
            $content_array[$middle] .= $code;
        } else {
            $content_array[1] .= $middle;
        }
        $content = implode('', $content_array);

        return $content;
    }
}

new Advertisement();

