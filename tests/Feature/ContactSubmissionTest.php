<?php

namespace Tests\Feature;

use App\Mail\ContactSubmissionReceived;
use App\Models\ContactSubmission;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    use RefreshDatabase;

    private array $payload = [
        'name'    => 'Connor Schriver',
        'email'   => 'connor.schriver@example.test',
        'company' => 'Brownclaw Asset Management',
        'phone'   => '6137958107',
        'message' => 'Bad actor on the No. 3 conveyor drive.',
    ];

    public function test_a_submission_is_stored_and_emailed_to_the_firm(): void
    {
        Mail::fake();
        SiteSetting::current()->update(['contact_email' => 'inbox@example.test']);

        $response = $this->post('/contact', $this->payload);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_submissions', [
            'email'  => 'connor.schriver@example.test',
            'source' => 'contact-page',
        ]);

        Mail::assertSent(
            ContactSubmissionReceived::class,
            fn (ContactSubmissionReceived $mail) => $mail->hasTo('inbox@example.test')
                && $mail->hasReplyTo('connor.schriver@example.test')
        );
    }

    public function test_the_notification_renders_without_errors(): void
    {
        $submission = ContactSubmission::create([
            ...$this->payload,
            'source' => 'contact-page',
        ]);

        $rendered = (new ContactSubmissionReceived($submission))->render();

        $this->assertStringContainsString('Connor Schriver', $rendered);
        $this->assertStringContainsString('No. 3 conveyor drive', $rendered);
        $this->assertStringContainsString('/admin/contact-submissions/' . $submission->id . '/edit', $rendered);
    }

    public function test_a_mail_failure_does_not_break_the_submission(): void
    {
        SiteSetting::current()->update(['contact_email' => 'inbox@example.test']);
        Mail::shouldReceive('to')->once()->andThrow(new \RuntimeException('SMTP is down'));

        $response = $this->post('/contact', $this->payload);

        $response->assertRedirect('/contact');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_submissions', ['email' => 'connor.schriver@example.test']);
    }

    public function test_an_optional_field_left_blank_is_accepted(): void
    {
        Mail::fake();
        SiteSetting::current()->update(['contact_email' => 'inbox@example.test']);

        $response = $this->post('/contact', [
            'name'    => 'Jane Doe',
            'email'   => 'jane@example.test',
            'message' => 'Hello.',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/contact');
    }

    public function test_the_mailtrap_sdk_transport_is_registered(): void
    {
        config()->set('services.mailtrap-sdk.apiKey', 'test-key');

        $this->assertNotNull(Mail::mailer('mailtrap-sdk'));
    }

    public function test_the_from_address_falls_back_to_the_mailtrap_sender(): void
    {
        $_ENV['MAILTRAP_FROM_EMAIL'] = 'bold@example.test';
        $_ENV['MAILTRAP_FROM_NAME'] = 'Bold News Wire';

        try {
            $config = require base_path('config/mail.php');

            $this->assertSame('bold@example.test', $config['from']['address']);
            $this->assertSame('Bold News Wire', $config['from']['name']);
        } finally {
            unset($_ENV['MAILTRAP_FROM_EMAIL'], $_ENV['MAILTRAP_FROM_NAME']);
        }
    }
}
