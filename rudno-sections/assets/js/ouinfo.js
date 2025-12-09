function removeParent(el) {
    jQuery(el).parent().remove();
}

jQuery(document).ready(function () {
    var maxKey = 0;

    jQuery('.add-hour-btn').click(function(){
        let day = jQuery(this).data('day');
        let key = jQuery(this).data('key') + 1;

        jQuery(this).data('key', key);

        let newItem = document.createElement('div');

        newItem.classList.add('mb-3');

        jQuery(this).parent().children('.times').append(newItem);

        jQuery(newItem).append(
            "<label for='rudno_ou_hours["+ day +"]["+ key +"][from]'>Od</label> <input type='text' class='mr-2' name='rudno_ou_hours["+ day +"]["+ key +"][from]' id='rudno_ou_hours["+ day +"]["+ key +"][from]' placeholder='12:00' required>"
        );

        jQuery(newItem).append(
            "<label for='rudno_ou_hours["+ day +"]["+ key +"][to]'>Do</label> <input type='text' class='mr-2' name='rudno_ou_hours["+ day +"]["+ key +"][to]' id='rudno_ou_hours["+ day +"]["+ key +"][to]' placeholder='12:00' pattern='[0-9]{1,2}:[0-9]{2}'>"
        );

        jQuery(newItem).append(
            "<span class='btn btn-danger btn-sm remove-hour-btn' onclick='removeParent(this)'>-</span>"
        );
    });
});
