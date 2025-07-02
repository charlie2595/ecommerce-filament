<?php

namespace App;

trait HasAlerts
{
    public function toastSuccess(string $title = 'Berhasil!', string $text = '')
    {
        $this->dispatch('swal', [
            'title'     => $title,
            'text'      => $text,
            'icon'      => 'success',
            'toast'     => true,
            'timer'     => 3000,
            'position'  => 'bottom-end',
            'showConfirmButton' => false,
            'customClass' => [
                'popup'         => 'rounded-lg text-sm p-4',
                'title'         => 'font-bold text-base',
                'htmlContainer' => 'text-gray-700',
            ],  
        ]);
    }

    public function toastError(string $title = 'Gagal!', string $text = '')
    {
        $this->dispatch('swal', [
            'title'    => $title,
            'text'     => $text,
            'icon'     => 'error',
            'toast'     => true,
            'timer'     => 3000,
            'position'  => 'bottom-end',
            'showConfirmButton' => false,
            'customClass' => [
                'popup'         => 'rounded-lg text-sm p-4',
                'title'         => 'font-bold text-base',
                'htmlContainer' => 'text-gray-700',
            ],  
        ]);
    }

    public function alertInfo(string $title, string $text = '')
    {
        $this->dispatch('swal', [
            'title' => $title,
            'text'  => $text,
            'icon'  => 'info',
        ]);
    }

    public function alertConfirm(string $title, string $confirmEvent, string $text = '', array $options = [])
    {
        $this->dispatch('swal:confirm', [
            'title'        => $title,
            'text'         => $text,
            'icon'         => 'warning',
            'confirmEvent' => $confirmEvent,
            ...$options,
        ]);
    }
}
