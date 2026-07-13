@props(['status'])

@php
    $statusConfig = [
        'pending' => ['bg' => 'warning', 'text' => 'Menunggu', 'icon' => 'clock'],
        'paid' => ['bg' => 'success', 'text' => 'Dibayar', 'icon' => 'check-circle'],
        'cancelled' => ['bg' => 'danger', 'text' => 'Dibatalkan', 'icon' => 'times-circle'],
        'expired' => ['bg' => 'secondary', 'text' => 'Kadaluarsa', 'icon' => 'exclamation-circle'],
    ];
    
    $config = $statusConfig[$status] ?? ['bg' => 'secondary', 'text' => 'Tidak Diketahui', 'icon' => 'question-circle'];
@endphp

<span class="badge badge-status bg-{{ $config['bg'] }}">
    <i class="fas fa-{{ $config['icon'] }} me-1"></i> {{ $config['text'] }}
</span>
