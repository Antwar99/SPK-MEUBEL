<?php
namespace App\Exports;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select('name', 'username', 'email', 'level')
            ->get()
            ->map(function ($user) {
                return [
                    'name'     => $user->name,
                    'username' => $user->username,
                    'email'    => $user->email,
                    'level'    => $user->level,
                    'password' => 'default123', // tampilkan sebagai info
                ];
            });
    }

    public function headings(): array
    {
        return ['Name', 'Username', 'Email', 'Level', 'Password'];
    }
}

