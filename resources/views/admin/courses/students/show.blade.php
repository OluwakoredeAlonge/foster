@extends('layouts.admin')

@section('title', $student->name)

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-4xl mx-auto">

    <a href="{{ route('admin.courses.students.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Students
    </a>

    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xl flex items-center justify-center flex-shrink-0">
                {{ strtoupper(substr($student->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $student->name }}</h2>
                <p class="text-sm text-gray-500">{{ $student->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mt-5 pt-5 border-t border-gray-100">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Joined</p>
                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $student->created_at->format('M j, Y') }}</p>
            </div>
            @if($student->phone)
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Phone</p>
                    <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $student->phone }}</p>
                </div>
            @endif
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Total Orders</p>
                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $student->courseOrders->count() }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Confirmed Courses</p>
                <p class="text-sm font-semibold text-gray-800 mt-0.5">{{ $student->courseOrders->where('status', 'confirmed')->count() }}</p>
            </div>
        </div>
    </div>

    @php
        $completedOrders = $student->courseOrders->where('status', 'confirmed');
    @endphp
    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Email Certificate</h3>
        @if($completedOrders->isEmpty())
            <p class="text-sm text-gray-400">{{ $student->name }} has no completed courses yet — a certificate can be sent once a course is confirmed.</p>
        @else
            <p class="text-xs text-gray-500 mb-4">Attach a certificate PDF and send it straight to {{ $student->email }}, with an optional note.</p>
            <form method="POST" action="{{ route('admin.courses.students.send-certificate', $student) }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Course</label>
                    <select name="course_order_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        @foreach($completedOrders as $order)
                            <option value="{{ $order->id }}" {{ (string) old('course_order_id') === (string) $order->id ? 'selected' : '' }}>
                                {{ $order->course->title }}{{ $order->course->has_certificate ? '' : ' (no certificate configured)' }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_order_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Certificate (PDF)</label>
                    <input type="file" name="certificate" accept="application/pdf" required
                        class="w-full text-xs text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-semibold file:text-xs">
                    @error('certificate')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        <p class="text-xs text-amber-600 mt-1">Please reselect the file below — browsers don't allow a page to pre-fill file selections after a reload.</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1">Message <span class="text-gray-400 font-normal">optional</span></label>
                    <textarea name="message" rows="3" placeholder="A short note to include in the email (optional)"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg transition">
                    Send Certificate
                </button>
            </form>
        @endif
    </div>

    <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Orders</h3>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Course</th>
                    <th class="text-left px-5 py-3">Amount</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Access Code</th>
                    <th class="text-left px-5 py-3">Date</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($student->courseOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <span class="font-semibold text-gray-900">{{ $order->course->title }}</span>
                            <p class="text-xs text-gray-400 font-mono">{{ $order->reference }}</p>
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
                        </td>
                        <td class="px-5 py-3 font-mono text-gray-700">{{ $order->access_code ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $order->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            @if($order->status === 'confirmed')
                                <form method="POST" action="{{ route('admin.courses.orders.revoke', $order) }}" class="inline"
                                      onsubmit="return confirm('Revoke {{ $student->name }}\'s access to {{ $order->course->title }}? Their code will stop working immediately.');">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Revoke Access</button>
                                </form>
                            @elseif($order->status === 'revoked')
                                <form method="POST" action="{{ route('admin.courses.orders.reinstate', $order) }}" class="inline"
                                      onsubmit="return confirm('Reinstate {{ $student->name }}\'s access to {{ $order->course->title }}? Their existing code will work again immediately.');">
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
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400">No orders yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
