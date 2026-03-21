<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FlashMessages
{
    protected function flashSuccess(string $message): void
    {
        session()->flash('success', $message);
    }

    protected function flashError(string $message): void
    {
        session()->flash('error', $message);
    }

    protected function flashWarning(string $message): void
    {
        session()->flash('warning', $message);
    }

    protected function flashInfo(string $message): void
    {
        session()->flash('info', $message);
    }

    protected function flashAndRedirect(string $message, string $route, Request $request, string $type = 'success'): \Illuminate\Http\RedirectResponse
    {
        $this->{"flash" . ucfirst($type)}($message);
        return redirect()->route($route);
    }
}
