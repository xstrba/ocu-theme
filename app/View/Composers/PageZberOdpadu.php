<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageZberOdpadu extends Composer
{

    public function subtitle()
    {
        return wpautop(get_option('rudno_waste_subtitle'));
    }

    public function address()
    {
        return get_option('rudno_waste_address');
    }

    public function contact()
    {
        return get_option('rudno_waste_contact');
    }

    public function opened()
    {
        return get_option('rudno_waste_opened');
    }

    public function picture()
    {
        return get_option('rudno_waste_picture');
    }
}
