<?php

namespace Addgod\MandrillTemplate;

use Addgod\MandrillTemplate\Mandrill\Attachment;
use Addgod\MandrillTemplate\Mandrill\Message;
use Addgod\MandrillTemplate\Mandrill\Recipient;
use Addgod\MandrillTemplate\Mandrill\Template;
use Illuminate\Notifications\Notification;
use RuntimeException;

class MandrillTemplateChannel
{
    /**
     * Send the notification as a Mandrill Template message.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return void
     * @throws \ReflectionException
     *
     */
    public function send($notifiable, Notification $notification): void
    {
        /** @var \Addgod\MandrillTemplate\MandrillTemplateMessage $templateMessage */
        $templateMessage = $notification->toMandrillTemplate($notifiable);

        if (empty($templateMessage->template)) {
            throw new RuntimeException('No Mandrill template was found');
        }

        if (is_string($recipients = $notifiable->routeNotificationFor('mail', $notification))) {
            $recipients = [$recipients];
        }

        foreach ($recipients as $email) {
            $templateMessage->to($email);
        }

        $template = new Template($templateMessage->template);

        list ($fromAddress, $fromName) = array_pad($templateMessage->from, 2, null);
        list ($replyToAddress, $replyToName) = array_pad($templateMessage->replyTo, 2, null);

        $message = new Message();
        $message
            ->setSubject($templateMessage->subject)
            ->setFromEmail($fromAddress ?? config('mail.from.address'))
            ->setFromName($fromName ?? config('mail.from.name'))
            ->addHeader('Reply-To', "$replyToName <$replyToAddress>")
            ->setMergeVars($templateMessage->toArray());

        foreach ($templateMessage->recipients as $entry) {
            list ($email, $name, $type) = $entry;
            $recipient = new Recipient($email, $name, $type);
            $message->addRecipient($recipient);
        }

        foreach ($templateMessage->attachments as $entry) {
            list ($file, $name) = $entry;
            $attachment = Attachment::createFromFile($file, $name);
            $message->addAttachment($attachment);
        }

        MandrillTemplateFacade::send($template, $message);
    }
}
