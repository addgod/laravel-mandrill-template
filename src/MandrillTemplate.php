<?php

namespace Addgod\MandrillTemplate;

use Addgod\MandrillTemplate\Mandrill\Message;
use Addgod\MandrillTemplate\Mandrill\Template;
use MailchimpTransactional\ApiClient;

class MandrillTemplate
{
    /**
     * @var \Mandrill
     */
    protected $api;

    /**
     * MandrillTemplate constructor.
     *
     * @throws \Mandrill_Error
     */
    public function __construct()
    {
        $this->api = new ApiClient();
        $this->api->setApiKey(config('mandrill-template.secret'));
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
     * @return array
     */
    public function send(Template $template, Message $message): array
    {
        $templateContent = $template->toArray();

        return $this->api->messages->sendTemplate(
            [
                'template_name' => $template->getName(),
                'template_content' => (count($templateContent['content']) > 0) ? $templateContent['content'] : '',
                'message' => $message->toArray()
            ]
        );
    }
}
