<?php

namespace Addgod\MandrillTemplate;

use Addgod\MandrillTemplate\Mandrill\Message;
use Addgod\MandrillTemplate\Mandrill\Template;
use Illuminate\Support\Facades\Facade;

/**
 * Class MandrillTemplateFacade
 *
 * @method static static send(Template $template, Message $message) Send template as message via mandrill.
 *
 * @package Addgod\MandrillTemplate
 */
class MandrillTemplateFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mandrill-template';
    }
}
