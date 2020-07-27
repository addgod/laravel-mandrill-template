<?php

namespace Addgod\MandrillTemplate;

use Addgod\MandrillTemplate\Mandrill\Message;
use Addgod\MandrillTemplate\Mandrill\Template;
use Mandrill;

class MandrillTemplate
{
    /**
     * @var \Mandrill
     */
    protected $client;

    /**
     * MandrillTemplate constructor.
     *
     * @throws \Mandrill_Error
     */
    public function __construct()
    {
        $this->api = new Mandrill(config('mandrill-template.secret'));
        if (config('app.debug')) {
            $this->api->debug = true;
        }
    }

    /**
     * Get the available templates.
     *
     * @return array
     */
    public function templates(): array
    {
        return config('mandrill-template.templates');
    }

    /**
     * Get the default template.
     *
     * @return string
     */
    public function defaultTemplate(): string
    {
        return config('mandrill-template.default_template');
    }

    /**
     * Send template as message via mandrill.
     *
     * @param \Addgod\MandrillTemplate\Mandrill\Template $template
     * @param \Addgod\MandrillTemplate\Mandrill\Message  $message
     *
     * @return void
     */
    public function send(Template $template, Message $message): void
    {
        $templateContent = $template->toArray();
        $this->api->messages->sendTemplate($template->getName(), (count($templateContent['content']) > 0 ) ? $templateContent['content'] : null , $message->toArray());
    }
}
