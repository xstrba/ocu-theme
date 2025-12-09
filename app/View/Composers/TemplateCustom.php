<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class TemplateCustom extends Composer
{

    protected $template = 'template-custom';

    public function foo()
    {
        return 'bar';
    }
}
