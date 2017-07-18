<?php

function remove_filter(string $par1, string $par2)
{
    if($par1 != 'content_save_pre' && $par1 != 'content_filtered_save_pre' )
    {
        throw Exception();
    }

    if($par2 != 'wp_filter_post_kses' && $par2 != 'wp_filter_post_kses' )
    {
        throw Exception();
    }
}

function wp_mkdir_p(string $par1)
{

}
function wp_check_filetype(string $filename, $par2)
{

}
function wp_insert_attachment($attachment, $file, $postId)
{

}

function wp_insert_post($post)
{
    return 1;
}

function wp_upload_dir()
{
    return [
        'path' => "test",
        'basedir' => "fixtures/wordpress/test"
    ];
}

function sanitize_file_name(string $filename)
{
    return $filename;
}