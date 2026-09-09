<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses | Heirs Hospital</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-white min-h-screen font-sans antialiased">

@include('courses.partials.topbar')

<main class="max-w-3xl mx-auto px-4 pb-16">
    <div class="pt-10 sm:pt-14 pb-6 border-b border-gray-100 mb-8">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">My Courses</h1>
        <p class="mt-2 text-gray-500">Track your orders and access codes here.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @forelse($orders as $order)
        <div class="mb-6">
            <div class="flex items-center gap-3 mb-3">
                @if($order->course->course_image_path)
                    <img src="{{ $order->course->course_image_path }}" alt="{{ $order->course->title }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                @else
                    <div class="w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="graduation-cap" class="w-6 h-6 text-emerald-500"></i>
                    </div>
                @endif
                <div>
                    <h2 class="font-bold text-gray-900">{{ $order->course->title }}</h2>
                    <p class="text-xs text-gray-400">Ordered {{ $order->created_at->diffForHumans() }}</p>
                </div>
            </div>

            @include('courses.orders._status', ['order' => $order, 'paymentSettings' => $paymentSettings])
        </div>
    @empty
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-50 rounded-full mb-5">
                <i data-lucide="graduation-cap" class="text-emerald-400 w-10 h-10"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">No courses yet</h3>
            <p class="text-gray-500 text-sm mb-5">Once you buy a course, it'll show up here.</p>
            <a href="{{ route('courses.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 transition shadow">
                <i data-lucide="layout-grid" class="w-4 h-4"></i>
                Browse Courses
            </a>
        </div>
    @endforelse
</main>

<footer class="bg-gray-900 text-gray-400 py-8">
    <div class="max-w-7xl mx-auto px-4 text-center text-sm">
        &copy; {{ date('Y') }} Heirs Hospital. All Rights Reserved.
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();

        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.copy-btn');
            if (!btn) return;
            copyTextToClipboard(btn.dataset.copy).then((success) => {
                if (success) {
                    const copyIcon = btn.querySelector('.copy-icon');
                    const successIcon = btn.querySelector('.copy-icon-success');
                    copyIcon.classList.add('hidden');
                    successIcon.classList.remove('hidden');
                    setTimeout(() => {
                        copyIcon.classList.remove('hidden');
                        successIcon.classList.add('hidden');
                    }, 1500);
                    showToast('Copied to clipboard');
                } else {
                    showToast('Could not copy — please copy it manually', true);
                }
            });
        });
    });

    // navigator.clipboard requires a secure context (https) — this app runs
    // on plain http in some environments, where it's simply undefined, so
    // the modern API silently does nothing. Fall back to the old
    // execCommand approach, which still works over http.
    async function copyTextToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            try {
                await navigator.clipboard.writeText(text);
                return true;
            } catch (e) {
                // fall through to the fallback below
            }
        }
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.focus();
        textarea.select();
        let success = false;
        try {
            success = document.execCommand('copy');
        } catch (e) {
            success = false;
        }
        document.body.removeChild(textarea);
        return success;
    }

    function showToast(message, isError = false) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-6 left-1/2 -translate-x-1/2 ${isError ? 'bg-red-600' : 'bg-gray-900'} text-white text-sm font-medium px-4 py-2.5 rounded-xl shadow-lg z-[100] flex items-center gap-2 opacity-0 transition-opacity duration-300`;
        toast.innerHTML = `<svg class="w-4 h-4 ${isError ? 'text-white' : 'text-emerald-400'}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span></span>`;
        toast.querySelector('span').textContent = message;
        document.body.appendChild(toast);
        requestAnimationFrame(() => { toast.style.opacity = '1'; });
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 2200);
    }
</script>
</body>
</html>
