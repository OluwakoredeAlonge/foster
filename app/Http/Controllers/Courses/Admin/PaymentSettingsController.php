<?php

namespace App\Http\Controllers\Courses\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoursePaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingsController extends Controller
{
    public function edit()
    {
        $settings = CoursePaymentSetting::current();

        return view('admin.courses.payment-settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:50'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'instructions' => ['nullable', 'string', 'max:5000'],
        ]);

        CoursePaymentSetting::current()->update($validated);

        return redirect()
            ->route('admin.courses.payment-settings.edit')
            ->with('success', 'Payment settings updated.');
    }
}
