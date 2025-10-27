{{-- resources/views/errors/404.blade.php --}}
@extends('errors.layout', [
    'code' => '404',
    'title' => 'الصفحة غير موجودة',
    'message' => 'عذرًا، الصفحة التي تبحث عنها غير موجودة أو تم نقلها.'
])
