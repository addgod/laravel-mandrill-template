<?php

namespace Addgod\MandrillTemplate;

use Addgod\MandrillTemplate\Mandrill\Recipient\Type;
use Illuminate\Notifications\Messages\SimpleMessage;

class MandrillTemplateMessage extends SimpleMessage
{
    /**
     * The name of the mandrill template
     *
     * @var string
     */
    public $template;

    /**
     * The from information
     *
     * @var array
     */
    public $from = [];

    /**
     * The replyTo information.
     *
     * @var array
     */
    public $replyTo = [];

    /**
     * The recipients array.
     *
     * @var array
     */
    public $recipients = [];

    /**
     * The attachments for the message.
     *
     * @var array
     */
    public $attachments = [];

    /**
     * The raw attachments for the message.
     *
     * @var array
     */
    public $rawAttachments = [];

    /**
     * Set the template name.
     *
     * @param string $template
     *
     * @return \Addgod\MandrillTemplate\MandrillTemplateMessage
     */
    public function template(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Set the form address.
     *
     * @param string      $address
     * @param string|null $name
     *
     * @return \Addgod\MandrillTemplate\MandrillTemplateMessage
     */
    public function from(string $address, string $name = null): self
    {
        $this->from = [$address, $name];

        return $this;
    }

    /**
     * Set the reply address.
     *
     * @param string      $address
     * @param string|null $name
     *
     * @return \Addgod\MandrillTemplate\MandrillTemplateMessage
     */
    public function replyTo(string $address, string $name = null): self
    {
        $this->replyTo = [$address, $name];

        return $this;
    }

    /**
     * Add recipient address.
     *
     * @param string $address
     * @param string $name
     *
     * @return \Addgod\MandrillTemplate\MandrillTemplateMessage
     */
    public function to(string $address, string $name = null): self
    {
        $this->recipients[] = [$address, $name, Type::TO];

        return $this;
    }

    /**
     * Add a cc recipient.
     *
     * @param string      $address
     * @param string|null $name
     *
     * @return \Addgod\MandrillTemplate\MandrillTemplateMessage
     */
    public function cc(string $address, string $name = null): self
    {
        $this->recipients[] = [$address, $name, Type::CC];

        return $this;
    }

    /**
     * Add a bcc recipient.
     *
     * @param string      $address
     * @param string|null $name
     *
     * @return \Addgod\MandrillTemplate\MandrillTemplateMessage
     */
    public function bcc(string $address, string $name = null): self
    {
        $this->recipients[] = [$address, $name, Type::BCC];

        return $this;
    }

    /**
     * Attach a file to the message.
     *
     * @param string $file
     * @param string $name
     *
     * @return $this
     */
    public function attach($file, string $name = null): self
    {
        $this->attachments[] = compact('file', 'name');

        return $this;
    }
}
