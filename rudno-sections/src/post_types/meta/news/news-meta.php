<?php

/**
 * Class News_Meta_Box
 */
abstract class News_Meta_Box
{
    const POST_TYPE =  'rudno-news';

    public static function add()
    {
        add_meta_box('news_meta_box', 'Viacej informácií', [self::class, 'html'], self::POST_TYPE);
    }

    /**
     * @param $news
     */
    public static function html($news)
    {
        ?>
        <div class="row mb-3">
            <label class="col-12 col-md-1" for="news_link">Odkaz pre viac informácií</label>
            <input type="text" class="col-12 col-md-10" name="news_link" id="news_link" maxlength="250"
            value="<?php echo $news->_link ?>" placeholder="napr.: /zastupitelstvo">
            <p class="col-12">
                <span>Odkaz slúži pri krátkych novinkách ako napríklad pozvánka na zastupiteľstvo pre
                presmerovanie na danú stránku.</span>
            </p>
        </div>
        <?php
    }

    /**
     * @param $postId
     */
    public static function save($postId)
    {
        if (array_key_exists('news_link', $_POST)) {
            update_post_meta($postId, '_link', filter_var($_POST['news_link'], FILTER_SANITIZE_URL));
        }
    }
}

add_action('add_meta_boxes', ['News_Meta_Box', 'add']);
add_action('save_post_' . News_Meta_Box::POST_TYPE, ['News_Meta_Box', 'save']);
