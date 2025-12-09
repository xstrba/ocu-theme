<?php


/**
 * Class Event_Meta_Box
 */
abstract class Event_Meta_Box
{
    const POST_TYPE = 'rudno-events';

    public static function add()
    {
        add_meta_box('event_meta_box', 'Ďalšie informácie', [self::class, 'html'], self::POST_TYPE);
    }

    /**
     * @param $event
     */
    public static function html($event)
    {
        wp_nonce_field('save_event', 'rudno_event_nonce');
?>
        <input type="hidden" name="event_updating" value="true">


        <div class="row mb-3">
            <label class="col-12 col-md-1" for="event_date_from">Dátum od</label>
            <input type="date" name="event_date_from" id="event_date_from" value="<?php echo $event->_date_from ?>" required>
            <label class="col-12 col-md-1" for="event_time_from">Čas od</label>
            <input type="time" name="event_time_from" id="event_time_from" value="<?php echo $event->_time_from ?>">
        </div>

        <div class="row mb-3">
            <label class="col-12 col-md-1" for="event_date_to">Dátum do</label>
            <input type="date" name="event_date_to" id="event_date_to" value="<?php echo $event->_date_to ?>">
            <label class="col-12 col-md-1" for="event_time_to">Čas do</label>
            <input type="time" name="event_time_to" id="event_time_to" value="<?php echo $event->_time_to ?>">
        </div>

        <div class="row mb-3">
            <label class="col-12 col-md-1" for="event_place">Miesto</label>
            <input type="text" class="col-12 col-md-10" name="event_place" id="event_place" maxlength="250"
            value="<?php echo $event->_place ?>" required>
        </div>

        <div class="row mb-3">
            <label class="col-12 col-md-1" for="event_link">Link pre viac informácií</label>
            <input type="text" class="col-12 col-md-10" name="event_link" id="event_link" maxlength="250"
            value="<?php echo $event->_link ?>">
        </div>
<?php
    }

    /**
     * @param $post_id
     */
    public static function save($post_id)
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if (array_key_exists('event_updating', $_POST) && check_admin_referer('save_event', 'rudno_event_nonce')) {
            if (array_key_exists('event_date_from', $_POST)) {
                update_post_meta($post_id, '_date_from', sanitize_text_field($_POST['event_date_from']));
            }

            if (array_key_exists('event_date_to', $_POST)) {
                update_post_meta($post_id, '_date_to', sanitize_text_field($_POST['event_date_to']));
            }

            if (array_key_exists('event_time_from', $_POST)) {
                update_post_meta($post_id, '_time_from', sanitize_text_field($_POST['event_time_from']));
            }

            if (array_key_exists('event_time_to', $_POST)) {
                update_post_meta($post_id, '_time_to', sanitize_text_field($_POST['event_time_to']));
            }

            if (array_key_exists('event_place', $_POST)) {
                update_post_meta($post_id, '_place', sanitize_text_field($_POST['event_place']));
            }

            if (array_key_exists('event_link', $_POST)) {
                update_post_meta($post_id, '_link', filter_var($_POST['event_link'], FILTER_SANITIZE_URL));
            }
        }
    }
}

add_action('add_meta_boxes', ['Event_Meta_Box', 'add']);
add_action('save_post_' . Event_Meta_Box::POST_TYPE, ['Event_Meta_Box', 'save']);
