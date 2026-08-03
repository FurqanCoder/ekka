<?php

namespace App\Livewire\Web;

use App\Models\ContactMessage;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class ContactUs extends Component
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $success = false;
    public $isSubmitting = false;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'subject' => 'required|string|min:3|max:255',
        'message' => 'required|string|min:10|max:5000',
    ];

    protected $messages = [
        'name.required' => 'Please enter your full name.',
        'name.min' => 'Name must be at least 3 characters.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'subject.required' => 'Please enter a subject.',
        'subject.min' => 'Subject must be at least 3 characters.',
        'message.required' => 'Please enter your message.',
        'message.min' => 'Message must be at least 10 characters.',
    ];

    public function submit()
    {
        $this->validate();

        $this->isSubmitting = true;

        try {
            // Save to database
            ContactMessage::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'subject' => $this->subject,
                'message' => $this->message,
                'ip_address' => request()->ip(),
            ]);

            // Send email notification to admin
            // Mail::to(config('mail.admin_email', 'admin@example.com'))->send(new ContactUsMail($this->all()));

            // Reset form
            $this->reset(['name', 'email', 'phone', 'subject', 'message']);
            $this->success = true;
            $this->isSubmitting = false;

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Your message has been sent successfully! We will get back to you soon.'
            ]);

        } catch (\Exception $e) {
            $this->isSubmitting = false;
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Something went wrong. Please try again later.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.web.contact-us')->extends('layouts.web')->section('web-content');
    }
}