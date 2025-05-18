<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendQrCodeToCustomer extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $qrCodePath;

    public function __construct($customer, $qrCodePath)
    {
        $this->customer = $customer;
        $this->qrCodePath = $qrCodePath;
    }

    public function build()
    {
        return $this->markdown('emails.qrcode')
                    ->subject('Your QR Code')
                    ->attach($this->qrCodePath, [
                        'as' => 'your_qr_code.svg',
                        'mime' => 'image/svg',
                    ]);
    }



}
