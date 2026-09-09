<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Heirs Hospital Courses</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-white min-h-screen font-sans antialiased">

@include('courses.partials.topbar')

<main class="max-w-lg mx-auto px-4 py-12">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-extrabold text-gray-900 mb-1">{{ $order->course->title }}</h1>
        <p class="text-sm text-gray-500">Reference: <span class="font-mono">{{ $order->reference }}</span></p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    @include('courses.orders._status', ['order' => $order, 'paymentSettings' => $paymentSettings])

    <a href="{{ route('courses.show', $order->course) }}" class="inline-block mt-6 text-emerald-700 font-semibold hover:underline text-sm">
        &larr; Back to course
    </a>
</main>

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
