<?php

namespace AnywhereMedia\PageEditor\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\View;
use Illuminate\Queue\SerializesModels;

class Enquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_from;
    public $mail_from_name;
    public $mail_title;
    public $enquiries;
    public $filesKeys;

    public function __construct($mail_from, $mail_from_name, $mail_title, $enquiries, $filesKeys)
    {
        $this->mail_from = $mail_from;
        $this->mail_from_name = $mail_from_name;
        $this->mail_title = $mail_title;
        $this->enquiries = $enquiries;
        $this->filesKeys = $filesKeys;
    }

    public function build()
    {
        $email_template = 'default';

        //create the email
        $email = $this->from($this->mail_from, $this->mail_from_name)
            ->subject($this->mail_from_name . ' - ' . $this->mail_title . ' [New Enquiry]')
            ->view('pageeditor::email-templates.' . $email_template)->with(['mailfromname'=>$this->mail_from_name]);

        //Attach files and unset in enquiry array
        foreach ($this->enquiries as $key => $enquiry){
            if(in_array($key, $this->filesKeys)){
                $email->attach(storage_path('app/' . $enquiry));
                unset($this->enquiries[$key]);
            }
        }

        return $email;
    }
}