<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // For exportng all table
        // return User::all();

        $usersData = User::select('id', 'name', 'address', 'city', 'state', 'country', 'pincode', 'mobile', 'email', 'created_at')->where('status', 1)->get();
        return $usersData;
    }

    public function headings(): array{
        return ['Id', 'Name', 'Address', 'City', 'State', 'Country', 'Pincode', 'Mobile', 'Email', 'Registered On'];
    }
}
