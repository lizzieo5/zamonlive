<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;

class NewsletterSubscriberSeeder extends Seeder
{
    public function run(): void
    {
        $emails = [
            'reader1@zamonlive.test',
            'reader2@zamonlive.test',
            'reader3@zamonlive.test',
            'reader4@zamonlive.test',
            'reader5@zamonlive.test',
            'reader6@zamonlive.test',
            'reader7@zamonlive.test',
            'reader8@zamonlive.test',
            'reader9@zamonlive.test',
            'reader10@zamonlive.test',
        ];

        foreach ($emails as $email) {
            NewsletterSubscriber::updateOrCreate(
                ['email' => $email],
                ['email' => $email]
            );
        }
    }
}
