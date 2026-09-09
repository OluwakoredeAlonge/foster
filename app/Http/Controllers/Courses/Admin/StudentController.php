<?php

namespace App\Http\Controllers\Courses\Admin;

use App\Http\Controllers\Concerns\ValidatesPdfUploads;
use App\Http\Controllers\Controller;
use App\Mail\CourseCertificateMail;
use App\Models\CourseOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    use ValidatesPdfUploads;

    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $query = User::where('role', 'student')
            ->withCount('courseOrders')
            ->withCount(['courseOrders as confirmed_orders_count' => function ($q) {
                $q->where('status', 'confirmed');
            }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(20)->appends($request->query());

        return view('admin.courses.students.index', compact('students', 'search'));
    }

    public function show(User $student)
    {
        abort_unless($student->role === 'student', 404);

        $student->load(['courseOrders' => function ($q) {
            $q->with('course')->latest();
        }]);

        return view('admin.courses.students.show', compact('student'));
    }

    public function sendCertificate(Request $request, User $student)
    {
        abort_unless($student->role === 'student', 404);

        $validated = $request->validate([
            'course_order_id' => ['required', 'integer'],
            'message' => ['nullable', 'string', 'max:2000'],
            'certificate' => ['required', 'file', 'max:10240', $this->isPdfRule()],
        ]);

        $order = CourseOrder::where('id', $validated['course_order_id'])
            ->where('user_id', $student->id)
            ->where('status', 'confirmed')
            ->with('course')
            ->first();

        if (! $order) {
            return back()->with('error', 'Select one of this student\'s completed courses before sending a certificate.');
        }

        try {
            Mail::to($student->email)->send(new CourseCertificateMail(
                studentName: $student->name,
                courseTitle: $order->course->title,
                customMessage: $validated['message'] ?? null,
                attachmentPath: $request->file('certificate')->getRealPath(),
                attachmentName: "{$order->course->title} Certificate.pdf",
            ));

            return back()->with('success', "Certificate emailed to {$student->name}.");
        } catch (\Throwable $e) {
            Log::error('Course certificate email failed: '.$e->getMessage(), [
                'student_id' => $student->id,
                'order_id' => $order->id,
            ]);

            return back()->with('error', 'Could not send the certificate email — check the mail configuration and try again.');
        }
    }
}
