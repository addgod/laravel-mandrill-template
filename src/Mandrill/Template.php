<?php

namespace Addgod\MandrillTemplate\Mandrill;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Template entity for sending.
 */
class Template implements Arrayable
{
    /**
     * The immutable name or slug of a template that exists in the user's account.
     * For backwards-compatibility, the template name may also be used but the immutable slug is preferred.
     *
     * @var string
     */
    private $name;

    /**
     * An array of template content to send.
     *
     * @var array
     */
    private $content = [];

    /**
     * Constructor.
     *
     * @param string $name
     *   Template immutable slug or name.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get template name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set template content using key/value entries.
     *
     * @param array $content
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Template
     *   The working instance for chaining.
     */
    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get template content.
     *
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Add the injection of a single piece of content into a single editable region.
     *
     * @param string $name
     *   The name of the mc:edit editable region to inject into.
     * @param string $content
     *   The content to inject
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Template
     *   The working instance for chaining.
     */
    public function addContent(string $name, string $content): self
    {
        $this->content[$name] = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'content' => Utils\ArrayHelper::assocToNameContent($this->content),
        ];
    }
}
