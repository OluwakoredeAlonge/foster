{{--
    Renders the right block for a CourseOrder's current status.
    Expects: $order (with `course` loaded), $paymentSettings (only needed
    while $order->status === 'pending').
--}}
@if($order->status === 'pending')
    <div class="border-2 border-amber-300 bg-amber-50/60 rounded-2xl p-5">
        <div class="flex items-center gap-2.5 mb-4">
            <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                <i data-lucide="triangle-alert" class="w-5 h-5 text-amber-700"></i>
            </div>
            <h3 class="font-extrabold text-gray-900 text-base">Important — Read Before You Pay</h3>
        </div>

        @if($paymentSettings->bank_name || $paymentSettings->account_number || $paymentSettings->account_name)
            <div class="bg-white border border-amber-200 rounded-xl p-4 text-sm space-y-1.5 mb-4 shadow-sm">
                @if($paymentSettings->bank_name)
                    <div class="flex justify-between"><span class="text-gray-500">Bank</span><span class="font-semibold text-gray-900">{{ $paymentSettings->bank_name }}</span></div>
                @endif
                @if($paymentSettings->account_number)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500">Account Number</span>
                        <span class="flex items-center gap-1.5">
                            <span class="font-semibold text-gray-900 font-mono">{{ $paymentSettings->account_number }}</span>
                            <button type="button" class="copy-btn text-gray-400 hover:text-emerald-600 transition p-0.5" data-copy="{{ $paymentSettings->account_number }}" title="Copy account number">
                                <i data-lucide="copy" class="w-3.5 h-3.5 copy-icon"></i>
                                <i data-lucide="check" class="w-3.5 h-3.5 copy-icon-success hidden text-emerald-600"></i>
                            </button>
                        </span>
                    </div>
                @endif
                @if($paymentSettings->account_name)
                    <div class="flex justify-between"><span class="text-gray-500">Account Name</span><span class="font-semibold text-gray-900">{{ $paymentSettings->account_name }}</span></div>
                @endif
                <div class="flex justify-between pt-1.5 border-t border-gray-100 mt-1.5"><span class="text-gray-500">Amount</span><span class="font-bold text-emerald-700">₦{{ number_format($order->amount, 2) }}</span></div>
            </div>
        @endif

        @if($paymentSettings->instructions)
            <div class="bg-white border border-amber-200 rounded-xl p-4 mb-4 shadow-sm">
                <p class="text-xs font-bold uppercase tracking-wide text-amber-700 mb-2">Instructions — follow these after paying</p>
                <p class="text-sm sm:text-base text-gray-900 font-medium leading-relaxed whitespace-pre-line">{{ $paymentSettings->instructions }}</p>
            </div>
        @else
            <p class="text-sm text-gray-700 font-medium mb-4">Make payment for this course, then let us know below.</p>
        @endif

        <form method="POST" action="{{ route('courses.orders.markPaid', $order) }}">
            @csrf
            <label class="flex items-start gap-2.5 text-sm text-gray-800 mb-4 bg-white border border-amber-200 rounded-xl p-3.5 cursor-pointer hover:border-emerald-300 transition">
                <input type="checkbox" name="acknowledged" required
                    class="mt-0.5 w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 flex-shrink-0">
                <span>I have read and understood the instructions above, and I confirm I have made this payment.</span>
            </label>
            @error('acknowledged')
                <p class="text-xs text-red-600 mb-3">{{ $message }}</p>
            @enderror
            <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow flex items-center justify-center gap-2">
                <i data-lucide="check-check" class="w-4 h-4"></i>
                I've Paid
            </button>
        </form>
    </div>
@elseif($order->status === 'awaiting_confirmation')
    <div class="border border-amber-200 bg-amber-50 rounded-2xl p-5 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-amber-100 rounded-full mb-3">
            <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm mb-1">Awaiting Confirmation</h3>
        <p class="text-sm text-gray-600">
            We've noted your payment for <strong>{{ $order->course->title }}</strong> and we're confirming it now. Check back here soon — your access code will appear once confirmed.
        </p>
    </div>
@elseif($order->status === 'confirmed' && $order->hasActiveAccess())
    <div class="border border-emerald-200 bg-emerald-50 rounded-2xl p-5 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 rounded-full mb-3">
            <i data-lucide="badge-check" class="w-6 h-6 text-emerald-600"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm mb-1">Payment Confirmed</h3>
        <p class="text-sm text-gray-600 mb-4">You now have full access to <strong>{{ $order->course->title }}</strong>.</p>

        <div class="bg-white border border-emerald-200 rounded-xl p-4 mb-4">
            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold mb-1">Your Access Code</p>
            <div class="flex items-center justify-center gap-2">
                <p class="text-2xl font-extrabold text-emerald-700 font-mono tracking-widest">{{ $order->access_code }}</p>
                <button type="button" class="copy-btn text-gray-400 hover:text-emerald-600 transition p-1" data-copy="{{ $order->access_code }}" title="Copy access code">
                    <i data-lucide="copy" class="w-4 h-4 copy-icon"></i>
                    <i data-lucide="check" class="w-4 h-4 copy-icon-success hidden text-emerald-600"></i>
                </button>
            </div>
            @if($order->access_expires_at)
                <p class="text-xs text-amber-600 mt-2">Access until {{ $order->access_expires_at->format('M j, Y') }}</p>
            @endif
        </div>

        <a href="{{ route('courses.show', $order->course) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition text-sm">
            <i data-lucide="circle-play" class="w-4 h-4"></i>
            Go to Course
        </a>
    </div>
@elseif($order->status === 'confirmed' && $order->isExpired())
    <div class="border border-red-200 bg-red-50 rounded-2xl p-5 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-3">
            <i data-lucide="clock" class="w-6 h-6 text-red-500"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm mb-1">Access Expired</h3>
        <p class="text-sm text-gray-600 mb-4">
            Your {{ $order->course->access_duration_months }}-month access to <strong>{{ $order->course->title }}</strong> ended on {{ $order->access_expires_at->format('M j, Y') }}. Please contact us if you'd like to renew.
        </p>
    </div>
@elseif($order->status === 'rejected')
    <div class="border border-red-200 bg-red-50 rounded-2xl p-5 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-3">
            <i data-lucide="circle-x" class="w-6 h-6 text-red-500"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm mb-1">Order Not Confirmed</h3>
        <p class="text-sm text-gray-600 mb-4">We couldn't confirm payment for this order. If you believe this is a mistake, please contact us, or try again below.</p>
        <a href="{{ route('courses.show', $order->course) }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl transition text-sm">
            Try Again
        </a>
    </div>
@elseif($order->status === 'revoked')
    <div class="border border-red-200 bg-red-50 rounded-2xl p-5 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-red-100 rounded-full mb-3">
            <i data-lucide="circle-x" class="w-6 h-6 text-red-500"></i>
        </div>
        <h3 class="font-bold text-gray-900 text-sm mb-1">Access Revoked</h3>
        <p class="text-sm text-gray-600 mb-4">Your access to <strong>{{ $order->course->title }}</strong> has been withdrawn. Please contact us if you believe this is a mistake.</p>
    </div>
@endif
