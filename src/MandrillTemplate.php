<?php

namespace Addgod\MandrillTemplate;

use Addgod\MandrillTemplate\Mandrill\Message;
use Addgod\MandrillTemplate\Mandrill\Template;
use Mandrill;

class MandrillTemplate
{
    /**
     * @var Mandrill
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
     * Send template as message via mandrill.
     *
     * @param \Addgod\MandrillTemplate\Mandrill\Template $template
     * @param \Addgod\MandrillTemplate\Mandrill\Message  $message
     */
    public function send(Template $template, Message $message)
    {
        $this->api->messages->sendTemplate($template->getName(), null, $message->toArray());
    }
}
