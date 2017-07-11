<?php
namespace rafaelglikis\autogp\DestinationSites;
use PHPUnit\Framework\Exception;

/** @noinspection PhpUndefinedFunctionInspection */
class WordpressDestinationSite extends DestinationSite
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
            print "[+] Article: " . $title . " added as " . $status . " [ categories: ". implode(",", $categoryIds) . " ]\n";
        }
        catch (Exception $exception) {
            print "[-] Problem adding article: " . $title . " - skipped\n";
            print $exception;
        }
    }

    /**
     * Set image to post
     */
    protected function setPostImage(int $postId, string $imageUrl)
    {
        $uploadDirectory = wp_upload_dir();
        $imageData = file_get_contents($imageUrl);
        $filename = uniqid().'_'.basename($imageUrl);

        $filename = preg_replace("/[^a-zA-Z0-9\".\"]/", "_", $filename);
        //var_dump($filename);
        if(wp_mkdir_p($uploadDirectory['path']))
            $file = $uploadDirectory['path'] . '/' . $filename;
        else
            $file = $uploadDirectory['basedir'] . '/' . $filename;
        file_put_contents($file, $imageData);
        $wpFileType = wp_check_filetype($filename, null );
        $attachment = array(
            'post_mime_type' => $wpFileType['type'],
            'post_title' => sanitize_file_name($filename),
            'post_content' => '',
            'post_status' => 'inherit'
        );

        $attachId = wp_insert_attachment($attachment, $file, $postId);
        require_once($this->wpPath . 'wp-admin/includes/image.php');
        $attachData = wp_generate_attachment_metadata( $attachId, $file );
        wp_update_attachment_metadata($attachId, $attachData);
        set_post_thumbnail($postId, $attachId);
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