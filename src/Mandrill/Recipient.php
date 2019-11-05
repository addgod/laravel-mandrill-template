<?php

namespace Addgod\MandrillTemplate\Mandrill;

use Addgod\MandrillTemplate\Mandrill\Recipient\Type;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Message recipient entity.
 */
class Recipient implements Arrayable
{
    /**
     * The email address of the recipient.
     *
     * @var string
     */
    private $email;

    /**
     * The optional display name to use for the recipient.
     *
     * @var string
     */
    private $name;

    /**
     * The header type to use for the recipient.
     *
     * @var string
     */
    private $type = Type::TO;

    /**
     * Per-recipient merge variables, which override global merge variables with the same name.
     *
     * @var array
     */
    private $mergeVars = [];

    /**
     * Per-recipient metadata that will override the global values specified in the metadata parameter.
     *
     * @var array
     */
    private $metadata = [];

    /**
     * Constructor.
     *
     * @param string $email
     * @param string $name
     * @param string $type
     *   Defaults to Recipient\Type::TO if not provided.
     *
     * @throws \ReflectionException
     */
    public function __construct(string $email, string $name = null, string $type = null)
    {
        $this->email = $email;
        $this->name = $name;
        if (in_array($type, Type::getValues())) {
            $this->type = $type;
        }
    }

    /**
     * Get recipient email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get recipient name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get recipient header type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set recipient merge variables using key/value entries.
     *
     * @param array $mergeVars
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Recipient
     *    The working instance for chaining.
     */
    public function setMergeVars(array $mergeVars): self
    {
        $this->mergeVars = $mergeVars;

        return $this;
    }

    /**
     * Get recipient merge variables.
     *
     * @return array
     */
    public function getMergeVars(): array
    {
        return $this->mergeVars;
    }

    /**
     * Add a single merge variable.
     *
     * @param string $name
     *   The merge variable's name. Merge variable names are case-insensitive and may not start with _.
     * @param mixed  $content
     *   The merge variable's content.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Recipient
     *    The working instance for chaining.
     */
    public function addMergeVar(string $name, $content): self
    {
        $this->mergeVars[$name] = $content;

        return $this;
    }

    /**
     * Remove a single merge variable.
     *
     * @param string $name
     *   The merge variable's name.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Recipient
     *   The working instance for chaining.
     */
    public function removeMergeVar(string $name): self
    {
        unset($this->mergeVars[$name]);

        return $this;
    }

    /**
     * Set recipient metadata using key/value entries.
     *
     * @param array $metadata
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Recipient
     *    The working instance for chaining.
     */
    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get recipient metadata.
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Add metadata for a single recipient.
     *
     * @param string $key
     * @param string $value
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Recipient
     *    The working instance for chaining.
     */
    public function addMetadata(string $key, string $value): self
    {
        $this->metadata[$key] = $value;

        return $this;
    }

    /**
     * Remove metadata for a single recipient.
     *
     * @param string $key
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Recipient
     *    The working instance for chaining.
     */
    public function removeMetadata(string $key): self
    {
        unset($this->metadata[$key]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'name'  => $this->name,
            'type'  => $this->type,
        ];
    }
}
