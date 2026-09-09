<?php

namespace App\Http\Controllers\Courses\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseOrder;
use Illuminate\Http\Request;

class CourseOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'awaiting_confirmation');

        $query = CourseOrder::with(['course', 'user'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20)->appends($request->query());

        $awaitingCount = CourseOrder::where('status', 'awaiting_confirmation')->count();

        return view('admin.courses.orders.index', compact('orders', 'status', 'awaitingCount'));
    }

    public function confirm(Request $request, CourseOrder $order)
    {
        abort_unless($order->status === 'awaiting_confirmation', 400);

        $validated = $request->validate([
            'access_code' => ['required', 'string', 'max:50', 'unique:course_orders,access_code'],
        ]);

        $order->confirm($validated['access_code']);

        return back()->with('success', "Order confirmed — access code {$order->access_code} issued to {$order->user->name}.");
    }

    public function reject(CourseOrder $order)
    {
        abort_unless(in_array($order->status, ['pending', 'awaiting_confirmation']), 400);

        $order->reject();

        return back()->with('success', 'Order rejected.');
    }

    public function revoke(CourseOrder $order)
    {
        abort_unless($order->status === 'confirmed', 400);

        $order->revoke();

        return back()->with('success', "Access revoked for {$order->user->name}.");
    }

    public function reinstate(CourseOrder $order)
    {
        abort_unless($order->status === 'revoked', 400);

        $order->reinstate();

        return back()->with('success', "Access reinstated for {$order->user->name}.");
    }
}
