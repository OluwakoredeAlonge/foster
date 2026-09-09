<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseOrder;
use App\Models\CoursePaymentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Course $course)
    {
        abort_unless($course->is_published, 404);

        // Enforced here too, not just by hiding the "Buy now" button — a
        // direct POST to this route must not bypass the registration
        // formality the admin turned on for this course.
        if ($course->needsRegistrationFrom(Auth::user())) {
            return redirect()->route('courses.registration.create', $course);
        }

        $existingOrder = $course->orderFor(Auth::user());

        if ($existingOrder) {
            return redirect()->route('courses.orders.show', $existingOrder);
        }

        $order = CourseOrder::create([
            'course_id' => $course->id,
            'user_id' => Auth::id(),
            'amount' => $course->price,
            'status' => 'pending',
            'reference' => 'CRS-'.strtoupper(Str::random(10)),
        ]);

        return redirect()->route('courses.orders.show', $order);
    }

    public function confirmation(CourseOrder $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('course');
        $paymentSettings = CoursePaymentSetting::current();

        return view('courses.checkout.confirmation', compact('order', 'paymentSettings'));
    }

    public function markPaid(Request $request, CourseOrder $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);
        abort_unless($order->status === 'pending', 400);

        // Enforced server-side, not just a disabled button — a checked box
        // recorded with a timestamp is the actual proof that the student
        // saw and accepted the payment instructions before claiming payment.
        $request->validate([
            'acknowledged' => ['accepted'],
        ], [
            'acknowledged.accepted' => 'Please confirm you have read the instructions above before continuing.',
        ]);

        $order->markPaidClaimed();

        return back()->with('success', 'Thanks! We\'ll confirm your payment shortly.');
    }

    public function index()
    {
        $orders = Auth::user()
            ->courseOrders()
            ->with('course')
            ->latest()
            ->get();

        $paymentSettings = CoursePaymentSetting::current();

        return view('courses.orders.index', compact('orders', 'paymentSettings'));
    }
}
