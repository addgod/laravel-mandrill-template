<?php

namespace Addgod\MandrillTemplate;

use Addgod\MandrillTemplate\Mandrill\Message;
use Addgod\MandrillTemplate\Mandrill\Template;
use Illuminate\Support\Facades\Facade;

/**
 * Class MandrillTemplateFacade
 *
 * @method static array send(Template $template, Message $message) Send template as message via mandrill.
 * @method static static templates() Get the available templates.
 * @method static static defaultTemplate() Get the default template.
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
    protected static function getFacadeAccessor(): string
    {
        return 'mandrill-template';
    }
}
