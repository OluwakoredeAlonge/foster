@extends('layouts.admin')

@section('title', 'Course Orders')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-6xl mx-auto">

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Course Orders</h2>
            <p class="mt-1 text-sm text-gray-600">Confirm payments and issue access codes.</p>
        </div>
    </div>

    {{-- Status tabs --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @foreach([
            'awaiting_confirmation' => 'Awaiting Confirmation',
            'all' => 'All',
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'rejected' => 'Rejected',
            'revoked' => 'Revoked',
        ] as $key => $label)
            <a href="{{ route('admin.courses.orders.index', ['status' => $key]) }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ $status === $key ? 'bg-emerald-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                {{ $label }}
                @if($key === 'awaiting_confirmation' && $awaitingCount > 0)
                    <span class="ml-1 {{ $status === $key ? 'bg-white/20' : 'bg-red-100 text-red-700' }} px-1.5 py-0.5 rounded-full text-xs">{{ $awaitingCount }}</span>
                @endif
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Course</th>
                    <th class="text-left px-5 py-3">Student</th>
                    <th class="text-left px-5 py-3">Amount</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Claimed</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <span class="font-semibold text-gray-900">{{ $order->course->title }}</span>
                            <p class="text-xs text-gray-400 font-mono">{{ $order->reference }}</p>
                        </td>
                        <td class="px-5 py-3 text-gray-700">
                            {{ $order->user->name }}
                            <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                        </td>
                        <td class="px-5 py-3 text-gray-700">₦{{ number_format($order->amount, 2) }}</td>
                        <td class="px-5 py-3">
                            @php
                                $badgeClass = match($order->status) {
                                    'confirmed' => 'bg-emerald-100 text-emerald-700',
                                    'awaiting_confirmation' => 'bg-amber-100 text-amber-700',
                                    'rejected', 'revoked' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                                $badgeLabel = match($order->status) {
                                    'awaiting_confirmation' => 'Awaiting Confirmation',
                                    default => ucfirst($order->status),
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">{{ $badgeLabel }}</span>
                            @if($order->access_code)
                                <p class="text-xs text-gray-400 font-mono mt-1">{{ $order->access_code }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-500 text-xs">
                            {{ $order->paid_claimed_at?->diffForHumans() ?? '—' }}
                        </td>
                        <td class="px-5 py-3 text-right">
                            @if($order->status === 'awaiting_confirmation')
                                <form method="POST" action="{{ route('admin.courses.orders.confirm', $order) }}"
                                      class="flex items-center gap-1.5 justify-end mb-1.5"
                                      onsubmit="return confirm('Confirm this payment and issue this access code?');">
                                    @csrf
                                    <input type="text" name="access_code" required placeholder="Access code"
                                        class="access-code-input w-32 px-2 py-1.5 border border-gray-300 rounded-lg text-xs font-mono focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <button type="button" onclick="suggestAccessCode(this)"
                                        class="text-gray-400 hover:text-emerald-600 transition p-1" title="Suggest a code">
                                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                                    </button>
                                    <button type="submit" class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold whitespace-nowrap">Confirm</button>
                                </form>
                                <form method="POST" action="{{ route('admin.courses.orders.reject', $order) }}" class="inline"
                                      onsubmit="return confirm('Reject this order?');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Reject</button>
                                </form>
                            @elseif($order->status === 'pending')
                                <form method="POST" action="{{ route('admin.courses.orders.reject', $order) }}" class="inline"
                                      onsubmit="return confirm('Reject this order?');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Reject</button>
                                </form>
                            @elseif($order->status === 'confirmed')
                                <form method="POST" action="{{ route('admin.courses.orders.revoke', $order) }}" class="inline"
                                      onsubmit="return confirm('Revoke {{ $order->user->name }}\'s access to this course? Their code will stop working immediately.');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Revoke Access</button>
                                </form>
                            @elseif($order->status === 'revoked')
                                <form method="POST" action="{{ route('admin.courses.orders.reinstate', $order) }}" class="inline"
                                      onsubmit="return confirm('Reinstate {{ $order->user->name }}\'s access to this course? Their existing code will work again immediately.');">
                                    @csrf
                                    <button type="submit" class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold">Reinstate Access</button>
                                </form>
                            @else
                                <span class="text-gray-300 text-xs">&mdash;</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                            No orders here.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>

<script>
    function suggestAccessCode(btn) {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // no 0/O/1/I to avoid confusion
        const part = () => Array.from({ length: 4 }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
        const input = btn.closest('form').querySelector('.access-code-input');
        input.value = `${part()}-${part()}`;
    }
</script>
@endsection
