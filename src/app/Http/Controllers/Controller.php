<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    /**
     * Flash a toast message to the session for global display.
     *
     * @param string $message
     * @param string $type
     * @param int $duration milliseconds
     * @return void
     */
    protected function toast(string $message, string $type = 'success', int $duration = 4000): void
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
        ]);
    }

    /**
     * Helper to flash and redirect back with optional message.
     */
    protected function toastRedirect(string $message, string $type = 'success', string $route = null): RedirectResponse
    {
        $this->toast($message, $type);

        return $route ? redirect()->route($route) : redirect()->back();
    }
}
