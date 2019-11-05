<?php

namespace Addgod\MandrillTemplate\Mandrill\Utils;

/**
 * Collection of array helper methods.
 */
class ArrayHelper
{
    /**
     * Convert an array from associative form to Mandrill's name-content form.
     *
     * @param array $arr
     *   Associative array with key/value content.
     *
     * @return array
     *   Indexed array in the name-content form, like so:
     *   [$key => $value] ==> [['name' => $key, 'content' => $value]].
     */
    public static function assocToNameContent(array $arr): array
    {
        $content = [];
        foreach ($arr as $key => $value) {
            $content[] = [
                'name'    => $key,
                'content' => $value,
            ];
        }

        return $content;
    }

    /**
     * Convert an array from Mandrill's name-content form to associative form.
     *
     * @param array $arr
     *   Indexed array in the name-content form.
     *
     * @return array
     *   Associative array with key/value content, like so:
     *   [['name' => $key, 'content' => $value]] ==> [$key => $value].
     */
    public static function nameContentToAssoc(array $arr): array
    {
        $content = [];
        foreach ($arr as $item) {
            $content[$item['name']] = $item['content'];
        }

        return $content;
    }
}
