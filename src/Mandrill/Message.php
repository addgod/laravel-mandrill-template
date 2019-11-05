<?php

namespace Addgod\MandrillTemplate\Mandrill;

use Illuminate\Contracts\Support\Arrayable;
use RuntimeException;

/**
 * Message entity for sending.
 */
class Message implements Arrayable
{
    /**
     * The message subject.
     *
     * @var string
     */
    private $subject;

    /**
     * The sender email address.
     *
     * @var string
     */
    private $fromEmail;

    /**
     * Optional from name to be used.
     *
     * @var string
     */
    private $fromName;

    /**
     * An array of recipients.
     *
     * @var array
     */
    private $recipients = [];

    /**
     * Optional extra headers to add to the message (most headers are allowed).
     *
     * @var array
     */
    private $headers = [];

    /**
     * Whether or not to expose all recipients in to "To" header for each email.
     *
     * @var bool
     */
    private $preserveRecipients = false;

    /**
     * Global merge variables to use for all recipients.
     * You can override these per recipient.
     *
     * @var array
     */
    private $mergeVars = [];

    /**
     * An array of string to tag the message with.
     * Stats are accumulated using tags, though we only store the first 100 we see,
     * so this should not be unique or change frequently.
     * Tags should be 50 characters or less.
     * Any tags starting with an underscore are reserved for internal use and will cause errors.
     *
     * @var array
     */
    private $tags = [];

    /**
     * An associative array of user metadata.
     * Mandrill will store this metadata and make it available for retrieval.
     * In addition, you can select up to 10 metadata fields to index and make searchable using the Mandrill search api.
     *
     * @var array
     */
    private $metadata = [];

    /**
     * An array of attachments to add to the message.
     *
     * @var array
     */
    private $attachments = [];

    /**
     * An array of embedded images to add to the message.
     *
     * @var array
     */
    private $images = [];

    /**
     * Set message subject.
     *
     * @param string $subject
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get message subject.
     *
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Set sender email.
     *
     * @param string $fromEmail
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function setFromEmail(string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Get sender email.
     *
     * @return string
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * Set sender display name.
     *
     * @param string $fromName
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function setFromName(string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get sender display name.
     *
     * @return string
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * Get message recipients.
     *
     * @return array<Recipient>
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Add message recipient.
     *
     * @param Recipient $recipient
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function addRecipient(Recipient $recipient): self
    {
        $this->recipients[$recipient->getEmail()] = $recipient;

        return $this;
    }

    /**
     * Remove message recipient by email.
     *
     * @param string $email
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function removeRecipient(string $email): self
    {
        unset($this->recipients[$email]);

        return $this;
    }

    /**
     * Clear list of recipients.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function clearRecipients(): self
    {
        $this->recipients = [];

        return $this;
    }

    /**
     * Set message headers using key/value entries.
     *
     * @param array $headers
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Get message headers.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Add message header.
     *
     * @param string $key
     * @param string $value
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * Remove message header.
     *
     * @param string $key
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function removeHeader(string $key): self
    {
        unset($this->headers[$key]);

        return $this;
    }

    /**
     * Set preserve recipients.
     *
     * @param bool $preserveRecipients
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function setPreserveRecipients(bool $preserveRecipients): self
    {
        $this->preserveRecipients = $preserveRecipients ? true : false;

        return $this;
    }

    /**
     * Get preserve recipients.
     *
     * @return bool
     */
    public function getPreserveRecipients(): bool
    {
        return $this->preserveRecipients;
    }

    /**
     * Set global merge variables using key/value entries.
     *
     * @param array $mergeVars
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function setMergeVars(array $mergeVars): self
    {
        $this->mergeVars = $mergeVars;

        return $this;
    }

    /**
     * Get global merge variables.
     *
     * @return array
     */
    public function getMergeVars(): array
    {
        return $this->mergeVars;
    }

    /**
     * Add a single global merge variable.
     *
     * @param string $name
     *   The global merge variable's name. Merge variable names are case-insensitive and may not start with _.
     * @param mixed  $content
     *   The global merge variable's content.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function addMergeVar(string $name, $content): self
    {
        $this->mergeVars[$name] = $content;

        return $this;
    }

    /**
     * Remove a single global merge variable.
     *
     * @param string $name
     *   The global merge variable's name.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function removeMergeVar(string $name): self
    {
        unset($this->mergeVars[$name]);

        return $this;
    }

    /**
     * Set message tags.
     *
     * @param array $tags
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get message tags.
     *
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Add a single tag - must not start with an underscore.
     *
     * @param string $tag
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *   The working instance for chaining.
     */
    public function addTag(string $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Set message metadata using key/value entries.
     *
     * @param array $metadata
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get message metadata.
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Add message metadata.
     *
     * @param string $key
     * @param string $value
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function addMetadata(string $key, string $value): self
    {
        $this->metadata[$key] = $value;

        return $this;
    }

    /**
     * Remove message metadata.
     *
     * @param string $key
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function removeMetadata(string $key): self
    {
        unset($this->metadata[$key]);

        return $this;
    }

    /**
     * Get message attachments.
     *
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * Add attachment to message.
     *
     * @param Attachment $attachment
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function addAttachment(Attachment $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Clear message attachments.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function clearAttachments(): self
    {
        $this->attachments = [];

        return $this;
    }

    /**
     * Get embedded message images.
     *
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * Add embedded image to message.
     *
     * @param \Addgod\MandrillTemplate\Mandrill\Attachment $image
     *   Must have a MIME type starting with 'image/'.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     * @throws \RuntimeException
     *   If MIME type doesn't start with 'image/'.
     *
     */
    public function addImage(Attachment $image): self
    {
        if (strpos($image->getType(), 'image/') === false) {
            throw new RuntimeException("MIME type must start with 'image/', was: " . $image->getType());
        }

        $this->images[] = $image;

        return $this;
    }

    /**
     * Clear embedded message images.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Message
     *    The working instance for chaining.
     */
    public function clearImages(): self
    {
        $this->images = [];

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        // Prepare recipients data.
        $to = [];
        $mergeVars = [];
        $recipientMetadata = [];

        foreach ($this->recipients as $email => $recipient) {
            $to[] = $recipient->toArray();
            // Handle merge vars.
            $vars = Utils\ArrayHelper::assocToNameContent($recipient->getMergeVars());
            if (!empty($vars)) {
                $mergeVars[] = [
                    'rcpt' => $email,
                    'vars' => $vars,
                ];
            }
            // Handle metadata.
            $values = $recipient->getMetadata();
            if (!empty($values)) {
                $recipientMetadata[] = [
                    'rcpt'   => $email,
                    'values' => $values,
                ];
            }
        }

        // Prepare attachments and images.
        $attachments = array_map(function ($attachment) {
            return $attachment->toArray();
        }, $this->attachments);

        $images = array_map(function ($image) {
            return $image->toArray();
        }, $this->images);

        return [
            'subject'             => $this->subject,
            'from_email'          => $this->fromEmail,
            'from_name'           => $this->fromName,
            'to'                  => $to,
            'headers'             => $this->headers,
            'preserve_recipients' => $this->preserveRecipients,
            'merge'               => true,
            'merge_language'      => 'handlebars',
            'global_merge_vars'   => Utils\ArrayHelper::assocToNameContent($this->mergeVars),
            'merge_vars'          => $mergeVars,
            'tags'                => $this->tags,
            'metadata'            => $this->metadata,
            'recipient_metadata'  => $recipientMetadata,
            'attachments'         => $attachments,
            'images'              => $images,
        ];
    }
}
