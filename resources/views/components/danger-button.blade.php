<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-red-500 focus:outline-none focus:ring-1 focus:ring-red-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
