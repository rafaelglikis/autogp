<?php
namespace rafaelglikis\autogp\DestinationSites;
use PHPUnit\Framework\Exception;
use rafaelglikis\autogp\DestinationSites\Interfaces\DestinationSite;

/** @noinspection PhpUndefinedFunctionInspection */
class WordpressDestinationSite implements DestinationSite
{
    const UNCATEGORIZED = 1;
    private $wpPath;

    public function __construct($wpPath)
    {
        $this->wpPath = $wpPath;
        require_once $this->getWpPath() . "wp-blog-header.php";

        remove_filter('content_save_pre', 'wp_filter_post_kses');
        remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');
    }

    protected function insertPost(string $title, string $imageUrl, string $content, string $status, $categoryIds = WordpressDestinationSite::UNCATEGORIZED)
    {
        // Make $category_ids array
        if (!is_array($categoryIds)) $categoryIds = array($categoryIds);

        // Create post object
        $myPost = array();
        $myPost['post_title'] = $title;
        $myPost['post_content'] = $content;
        $myPost['post_status'] = $status;
        $myPost['post_category'] = $categoryIds;

        try {
            $postId = wp_insert_post($myPost); // Insert post (wordpress way)
            $this->setPostImage($postId, $imageUrl); // Set Image (wordpress way)
            print "[+] Article: " . $title . " added as " . $status . "\n";
        }
        catch (Exception $exception) {
            print "[-] Problem adding article: " . $title . " - skipped";
            print $exception;
        }
    }

    /**
     * Set image to post
     */
    protected function setPostImage(int $postId, string $imageUrl)
    {
        $upload_dir = wp_upload_dir();
        $image_data = file_get_contents($imageUrl);
        $filename = uniqid().'_'.basename($imageUrl);

        $filename = preg_replace("/[^a-zA-Z0-9\".\"]/", "_", $filename);
        //var_dump($filename);
        if(wp_mkdir_p($upload_dir['path']))
            $file = $upload_dir['path'] . '/' . $filename;
        else
            $file = $upload_dir['basedir'] . '/' . $filename;
        file_put_contents($file, $image_data);
        $wp_filetype = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attach_id = wp_insert_attachment($attachment, $file, $postId);
        require_once($this->wpPath . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata($attach_id, $attach_data);
        set_post_thumbnail($postId, $attach_id);
    }

    public function insertDraftPost(string $title, string $imageUrl, string $content, $categoryIds = WordpressDestinationSite::UNCATEGORIZED) {
        WordpressDestinationSite::insertPost($title, $imageUrl, $content,  'draft', $categoryIds);
    }

    public function insertPublishedPost(string $title, string $imageUrl, string $content, $categoryIds = WordpressDestinationSite::UNCATEGORIZED) {
        WordpressDestinationSite::insertPost($title, $imageUrl, $content, 'publish', $categoryIds);
    }

    public function getWpPath(): string {
        return $this->wpPath;
    }
}