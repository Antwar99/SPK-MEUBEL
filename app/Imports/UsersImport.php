<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Collection;

class UsersImport implements
    ToCollection,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    WithBatchInserts
{
    use Importable, SkipsErrors;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            User::updateOrCreate(
                ['username' => $row['username']], // Kunci unik
                [
                    'name'     => $row['name'],
                    'email'    => $row['email'],
                    'password' => isset($row['password']) && $row['password'] !== ''
                        ? Hash::make($row['password'])
                        : Hash::make('default123'),
                    'level'    => $row['level'],
                ]
            );
        }
    }

    public function rules(): array
    {
        return [
            'name'     => ['required'],
            'email'    => ['required', 'email'],
            'username' => ['required'],
            'level'    => ['required'],
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function customValidationMessages()
    {
        return [
            'name.required'     => 'Kolom nama wajib diisi.',
            'email.required'    => 'Kolom email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'username.required' => 'Kolom username wajib diisi.',
            'level.required'    => 'Level pengguna wajib diisi.',
        ];
    }
}
