<?php

namespace App\Services;

class NotificationService
{
    public static function created(mixed $message = null): void
    {
        notyf()->success($message ?? __('Created Successfully'));
    }

    public static function updated(mixed $message = null): void
    {
        notyf()->success($message ?? __('Updated Successfully'));
    }

    public static function deleted(mixed $message = null): void
    {
        notyf()->success($message ?? __('Deleted Successfully'));
    }

    public static function error(mixed $message = null): void
    {
        notyf()->error($message ?? __('Something went wrong!'));
    }
}
