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
        $email = end($this->emails);
        //dd($email->getTo());
        $this->assertArrayHasKey(
            $recipient,
            $email->getTo(),
            "No email was sent to $recipient."
        );
        return $this;
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
