<?php

namespace Addgod\MandrillTemplate\Mandrill\Recipient;

use Addgod\MandrillTemplate\Mandrill\Utils\EnumTrait;

/**
 * Message recipient type.
 */
class Type
{
    use EnumTrait;

    const TO  = 'to';
    const CC  = 'cc';
    const BCC = 'bcc';
}
