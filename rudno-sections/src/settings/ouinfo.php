<?php
/**
 * Create custom settings page for ou basic info
 */

// register top_level_menu
function rudno_ou_setting_page()
{
    add_menu_page('Obecný úrad', 'Obecný úrad', 'edit_posts', 'rudno_ou_info', 'rudno_ou_setting_cb', 'dashicons-building', 43);
}

function rudno_ou_setting_cb()
{
    // check user capabilities
    if ( ! current_user_can( 'edit_posts' ) ) {
        return;
    }

    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'rudno_ou_messages', 'rudno_ou_message', 'Nastavenia uložené', 'updated' );
    }

    // show error/update messages
    settings_errors( 'rudno_ou_messages' );

    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post" enctype="multipart/form-data">
            <?php
            // output security fields for the registered setting "hours"
            settings_fields( 'rudno_ou' );
            // output setting sections and their fields
            do_settings_sections( 'rudno_ou' );
            // output save settings button
            submit_button( 'Uložiť' );
            ?>
        </form>
    </div>
    <?php
}

add_action( 'admin_menu', 'rudno_ou_setting_page');

function rudno_set_ou_settings()
{
    add_settings_section('rudno_ou_basic', 'Základné', '', 'rudno_ou');
    add_settings_section('rudno_ou_hours', 'Otváracie hodiny', '', 'rudno_ou');
    add_settings_section('rudno_ou_preview', 'Obrázok', '', 'rudno_ou');


    $commonArgs = [];

    $settings = [
        'rudno_ou_address',
        'rudno_ou_phone',
        'rudno_ou_mail',
        'rudno_ou_facebook',
        'rudno_ou_hours',
        'rudno_ou_preview',
    ];

    foreach ($settings as $setting) {
        register_setting('rudno_ou', $setting, $commonArgs);
    }

    // basic section settings fields
    add_settings_field('rudno_ou_address_field', 'Adresa', 'rudno_ou_address_cb', 'rudno_ou', 'rudno_ou_basic');
    add_settings_field('rudno_ou_phone_field', 'Telefón', 'rudno_ou_phone_cb', 'rudno_ou', 'rudno_ou_basic');
    add_settings_field('rudno_ou_mail_field', 'Mail', 'rudno_ou_mail_cb', 'rudno_ou', 'rudno_ou_basic');
    add_settings_field('rudno_ou_facebook_field', 'Link na facebook stránku', 'rudno_ou_facebook_cb', 'rudno_ou', 'rudno_ou_basic');

    // add days settings fields
    add_settings_field('rudno_ou_hours_pon', 'Pondelok', 'rudno_ou_hours_cb', 'rudno_ou', 'rudno_ou_hours',
                        array('day' => 0));
    add_settings_field('rudno_ou_hours_uto', 'Utorok', 'rudno_ou_hours_cb', 'rudno_ou', 'rudno_ou_hours',
                        array('day' => 1));
    add_settings_field('rudno_ou_hours_str', 'Streda', 'rudno_ou_hours_cb', 'rudno_ou', 'rudno_ou_hours',
                        array('day' => 2));
    add_settings_field('rudno_ou_hours_stv', 'Štrvrtok', 'rudno_ou_hours_cb', 'rudno_ou', 'rudno_ou_hours',
                        array('day' => 3));
    add_settings_field('rudno_ou_hours_pia', 'Piatok', 'rudno_ou_hours_cb', 'rudno_ou', 'rudno_ou_hours',
                        array('day' => 4));

    add_settings_field('rudno_ou_preview_field', 'Obrázok', 'rudno_preview_cb', 'rudno_ou', 'rudno_ou_preview');
}

function rudno_ou_address_cb()
{
    $option = get_option('rudno_ou_address', null);

    ?>
        <input type="text" name="rudno_ou_address" id="rudno_ou_address" value="<?php echo $option ?>">
    <?php
}

function rudno_ou_phone_cb()
{
    $option = get_option('rudno_ou_phone', null);

    ?>
        <input type="text" name="rudno_ou_phone" id="rudno_ou_phone" value="<?php echo $option ?>">
    <?php
}

function rudno_ou_mail_cb()
{
    $option = get_option('rudno_ou_mail', null);

    ?>
        <input type="text" name="rudno_ou_mail" id="rudno_ou_mail" value="<?php echo $option ?>" placeholder="rudno@mail.com" pattern="^[^@]+@[^@\.]+\.[a-zA-Z]+">
    <?php
}

function rudno_ou_facebook_cb()
{
    $option = get_option('rudno_ou_facebook', null);

    ?>
        <input type="text" name="rudno_ou_facebook" id="rudno_ou_facebook" value="<?php echo $option ?>" placeholder="https://www.facebook.com/ObecMenoObce/">
    <?php
}

function rudno_ou_hours_cb($args)
{
    $option = get_option('rudno_ou_hours', null);
    $maxKey = 0;

    ?>
        <div class="bg-light p-2">
        <div class="times">
    <?php
    foreach ($option[$args['day']] ?? [] as $key => $hours) {
        ?>
        <div class="mb-3">
            <label for="rudno_ou_hours[<?php echo $args['day'] ?>][<?php echo $key ?>][from]">Od</label>
            <input type="text"
                class='mr-2'
                name="rudno_ou_hours[<?php echo $args['day'] ?>][<?php echo $key ?>][from]"
                id="rudno_ou_hours[<?php echo $args['day'] ?>][<?php echo $key ?>][from]"
                value="<?php echo $hours['from'] ?>"
                placeholder="12:00"
                required
            ><label for="rudno_ou_hours[<?php echo $args['day'] ?>][<?php echo $key ?>][to]">Do</label>
            <input type="text"
                class='mr-2'
                name="rudno_ou_hours[<?php echo $args['day'] ?>][<?php echo $key ?>][to]"
                id="rudno_ou_hours[<?php echo $args['day'] ?>][<?php echo $key ?>][to]"
                value="<?php echo $hours['to'] ?>"
                placeholder="12:00"
                pattern="[0-9]{1,2}:[0-9]{2}"
            ><span class="btn btn-danger btn-sm" onclick="removeParent(this)">-</span>

        </div>
        <?php
        $maxKey = $key;
    }

    ?>
    </div>

    <span class="btn btn-primary btn-sm add-hour-btn"
            data-day="<?php echo $args['day'] ?>"
            data-key="<?php echo $maxKey ?>">+</span>
    </div>
    <?php
}

function rudno_preview_cb()
{
    $fileMeta = get_option('rudno_ou_preview');

    if ($fileMeta) {
        $fileUrl = get_post($fileMeta)->guid;
        $url = explode('/uploads/', $fileUrl)[1];
    }
    ?>

    <div class="row mb-3">
        <img src="<?php echo get_post($fileMeta)->guid ?: "https://dummyimage.com/100x100/8f8f8f/fff" ?>" alt="Nitrianske Rudno" height="100" id="spost_file_preview">
    </div>
    <div class="row mb-3" id="spost_file_area">
        <input type="hidden" name="rudno_ou_preview" id="spost_file" value="<?php if ( isset ( $fileMeta ) ) echo $fileMeta; ?>">
        <input type="text" id="spost_file_txt" class="col-md-4" value="<?php if ( isset ( $url ) ) echo $url; ?>" readonly aria-labeledby="spost_file_button" pattern=".*\.pdf" required>
        <button class="ml-1" type="button" id="spost_file_button">Vybrať obrázok</button>
    </div>
    <?php
}

add_action( 'admin_init', 'rudno_set_ou_settings');
add_filter('option_page_capability_rudno_ou', function($_) {
    return 'edit_posts';
});
