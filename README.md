# Mandrill Templates for Laravel
A way to send mail via mandrills template system.

## Installation
### Requirements
- PHP 7.2
- Laravel 6

You can install the package via composer:

```bash
composer require addgod/laravel-mandrill-template
```

To public the config file run:

```php
php artisan vendor:publish --provider="Addgod\MandrillTemplate\MandrillTemplateServiceProvider"
```

## Usage
Add your mandrill secret key to your .env file.

```bash
MANDRILL_SECRET="YOUR SECRET KEY"
```

### Sending mail

```php
use Addgod\MandrillTemplate\Mandrill\Message;
use Addgod\MandrillTemplate\Mandrill\Template;
use Addgod\MandrillTemplate\Mandrill\Recipient;
use Addgod\MandrillTemplate\Mandrill\Attachment;
use Addgod\MandrillTemplate\Mandrill\Recipient\Type;
use Addgod\MandrillTemplate\MandrillTemplateFacade;
```

```php
$template = new Template('template-name');
$message = new Message();
$message
    ->setSubject('Subjct')
    ->setFromEmail('from@example.com')
    ->setFromName('Example Name')
    ->setMergeVars(['greeting' => 'Hello to you']);

$message->addRecipient(new Recipient('to@example.com', 'Example Name', Type::TO));
$message->addAttachment(Attachment::createFromFile($file, 'name_of_file');

MandrillTemplateFacade::send($template, $message);
```

### Via notifications
Create a new notification

```bash
php artisan make:notification WelcomeNotification
```

Set `via` to `MandrillTemplateChannel`:

```php
use Addgod\MandrillTemplate\MandrillTemplateChannel;
```

```php
/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return [MandrillTemplateChannel::class];
}
```

Implement `toMandrillTemplate` method and prepare your template:

```php
use Addgod\MandrillTemplate\MandrillTemplateMessage;
```

```php
public function toMandrillTemplate($notifiable)
{
    return (new MandrillTemplateMessage)
        ->template('notification')
        ->from('from@example.com', 'Example dot com')
        ->to('to@example.com', 'Frank Kornell') // This is an extra to, since the notifiable is also used.
        ->cc('cc@example.com', 'Charlott Kornell')
        ->bcc('bcc@example.com', 'Mr admin Dude')
        ->greeting('Hello there'),
        ->line('The introduction to the notification.')
        ->action('Notification Action', url('/'))
        ->line('Thank you for using our application!')
        ->salutation('Regards from us.'
        ->attach($file, 'name_of_file);
}
```
