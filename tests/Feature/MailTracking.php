<?php

namespace Tests\Feature;

use Mail;
use Swift_Events_EventListener;
use Swift_Message;

trait MailTracking
{
    protected $emails = [];

    public function setUpMailTracking()
    {
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));
    }

    protected function seeEmailWasSent()
    {
        $this->assertNotEmpty(
            $this->emails,
            'No emails have been sent.'
        );
        return $this;
    }

    protected function seeEmailWasNotSent()
    {
        $this->assertEmpty(
            $this->emails,
            'Did not expect any emails to have been sent.'
        );
        return $this;
    }

    protected function seeEmailEquals($body, Swift_Message $message = null)
    {
        $this->assertEquals(
            $body,
            $this->getEmail($message)->getBody(),
            "The no email with the provided content was sent."
        );
        return $this;
    }

    protected function seeEmailContains($excerpt, Swift_Message $message = null)
    {
        $this->assertContains(
            $excerpt,
            $this->getEmail($message)->getBody(),
            "The no email containing the provided body was found."
        );
        return $this;
    }

    protected function seeEmailSubjectEquals($subject, Swift_Message $message = null)
    {
        $this->assertEquals(
            $subject,
            $this->getEmail($message)->getSubject(),
            "The no email containing the provided subject was found."
        );
        return $this;
    }

    protected function seeNumberOfEmailsSent($count)
    {
        $numberSent = count($this->emails);
        $this->assertCount(
            $count,
            $this->emails,
            "Expected $count emails to have been sent, but only sent $numberSent."
        );
        return $this;
    }

    protected function seeEmailTo($recipient, Swift_Message $message = null)
    {
        // dd($this->getEmail($message));
        $this->assertArrayHasKey(
            $recipient,
            $this->getEmail($message)->getTo(),
            "No email was sent to $recipient."
        );
        return $this;
    }

    protected function seeEmailFrom($sender, Swift_Message $message = null)
    {
        // dd($this->getEmail($message));
        $this->assertArrayHasKey(
            $sender,
            $this->getEmail($message)->getFrom(),
            "No email was sent from $sender."
        );
        return $this;
    }

    protected function getEmail(Swift_Message $message = null)
    {
        return $message ?: $this->lastEmail();
    }

    protected function lastEmail()
    {
        $this->seeEmailWasSent();
        return end($this->emails);
    }

    public function addEmail(Swift_Message $email)
    {
        $this->emails[] = $email;
        return $this;
    }
}

class TestingMailEventListener implements Swift_Events_EventListener
{
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }

    public function beforeSendPerformed($event)
    {
        $message = $event->getMessage();

        // dd(get_class_methods($message));
        $this->test->addEmail($message);
    }
}
