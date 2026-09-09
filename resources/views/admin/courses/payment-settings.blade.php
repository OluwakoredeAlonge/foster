@extends('layouts.admin')

@section('title', 'Payment Settings')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-2xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Payment Settings</h2>
        <p class="mt-1 text-sm text-gray-600">
            This information is shown to students at checkout for every course, and to yourself in the Orders queue.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.courses.payment-settings.update') }}"
          class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Bank Name</label>
                <input type="text" name="bank_name" value="{{ old('bank_name', $settings->bank_name) }}"
                    placeholder="e.g., Guaranty Trust Bank"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('bank_name') border-red-400 @else border-gray-300 @enderror">
                @error('bank_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Account Number</label>
                <input type="text" name="account_number" value="{{ old('account_number', $settings->account_number) }}"
                    placeholder="e.g., 0123456789"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('account_number') border-red-400 @else border-gray-300 @enderror">
                @error('account_number')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Account Name</label>
                <input type="text" name="account_name" value="{{ old('account_name', $settings->account_name) }}"
                    placeholder="e.g., Heirs Hospital Limited"
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('account_name') border-red-400 @else border-gray-300 @enderror">
                @error('account_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Instructions for Students</label>
                <textarea name="instructions" rows="6"
                    placeholder="e.g., Transfer the exact course amount to the account above, then click &quot;I've Paid&quot; below. We'll confirm your payment and send your access code within 24 hours."
                    class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('instructions') border-red-400 @else border-gray-300 @enderror">{{ old('instructions', $settings->instructions) }}</textarea>
                @error('instructions')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-400 mt-1">Shown alongside your bank details on every course's checkout page.</p>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
