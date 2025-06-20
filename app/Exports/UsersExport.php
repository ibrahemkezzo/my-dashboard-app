<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::query()->with('roles')->get();
    }

    public function headings(): array
    {
        return ['الاسم', 'البريد الإلكتروني', 'الأدوار', 'الحالة'];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->email,
            $user->roles->pluck('name')->implode(', ') ?: 'لا توجد أدوار',
            $user->is_active ? 'مفعل' : 'معطل',
        ];
    }
}