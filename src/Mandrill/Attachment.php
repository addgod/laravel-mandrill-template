<?php

namespace Addgod\MandrillTemplate\Mandrill;

use Illuminate\Contracts\Support\Arrayable;
use RuntimeException;

/**
 * Message attachment entity.
 */
class Attachment implements Arrayable
{
    /**
     * The MIME type of the attachment.
     *
     * @var string
     */
    private $type;

    /**
     * The name of the attachment.
     *
     * @var string
     */
    private $name;

    /**
     * The content of the attachment as a base64-encoded string.
     *
     * @var string
     */
    private $content;

    /**
     * Constructor.
     *
     * @param string $type
     * @param string $name
     * @param string $content
     */
    public function __construct(string $type, string $name, string $content)
    {
        $this->type = $type;
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * Get attachment MIME type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get attachment name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get attachment content as a base64-encoded string.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'type'    => $this->type,
            'name'    => $this->name,
            'content' => $this->content,
        ];
    }

    /**
     * Create an attachment instance from a file path.
     *
     * @param string $path
     * @param string $name
     *   Defaults to filename.
     *
     * @return \Addgod\MandrillTemplate\Mandrill\Attachment
     * @throws \RuntimeException
     *   If file path is invalid, or file reading failed.
     *
     */
    public static function createFromFile(string $path, string $name = null): Attachment
    {
        if (!file_exists($path)) {
            throw new RuntimeException('No valid file found at specified path: ' . $path);
        }

        $type = mime_content_type($path);
        if (!$name) {
            $name = basename($path);
        }
        $content = file_get_contents($path);
        if ($content === false) {
            throw new RuntimeException('Failed to read content from file: ' . $path);
        }

        return new self($type, $name, base64_encode($content));
    }
}
