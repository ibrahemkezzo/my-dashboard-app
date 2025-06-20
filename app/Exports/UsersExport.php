<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected ?string $search;
    protected ?array $roleNames;

    public function __construct(?string $search = null, ?array $roleNames = null)
    {
        $this->search = $search;
        $this->roleNames = $roleNames;
    }

    public function collection()
    {
        $query = User::query()->with('roles');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        if ($this->roleNames) {
            $query->whereHas('roles', function ($q) {
                $q->whereIn('name', $this->roleNames);
            });
        }

        return $query->get();
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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}