<?php

namespace App\Exports;

use App\Models\NewsletterSubscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscriberExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return NewsletterSubscriber::all();
        $subscribersData = NewsletterSubscriber::select('id', 'email', 'created_at')->orderBy('id', 'DESC')->get();
        return $subscribersData;
    }

    public function headings(): array{
        return ['Id', 'Email', 'Subscriber On'];
    }
}
