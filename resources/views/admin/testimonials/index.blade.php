@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="flex-1">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Testimonials</h2>
            <p class="mt-1 text-sm text-gray-600">Manage the "What Our Clients Say" section on the homepage.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}"
            class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 text-sm font-semibold">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Testimonial
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Client</th>
                    <th class="text-left px-5 py-3">Quote</th>
                    <th class="text-left px-5 py-3">Rating</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($testimonials as $testimonial)
                    <tr class="hover:bg-gray-50 align-top">
                        <td class="px-5 py-3">
                            <span class="font-semibold text-gray-900">{{ $testimonial->client_name }}</span>
                            @if($testimonial->client_role)
                                <p class="text-xs text-gray-400">{{ $testimonial->client_role }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600 max-w-sm">
                            <p class="line-clamp-2">{{ $testimonial->quote }}</p>
                        </td>
                        <td class="px-5 py-3 text-amber-500">{{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}</td>
                        <td class="px-5 py-3">
                            @if($testimonial->is_visible)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Shown</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">Hidden</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.testimonials.toggle', $testimonial) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold {{ $testimonial->is_visible ? 'text-gray-500 hover:text-gray-800' : 'text-emerald-700 hover:text-emerald-900' }} mr-3">
                                    {{ $testimonial->is_visible ? 'Hide' : 'Show' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-3">Edit</a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="inline"
                                  onsubmit="return confirm('Remove this testimonial?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            No testimonials yet. <a href="{{ route('admin.testimonials.create') }}" class="text-emerald-600 font-semibold hover:underline">Add one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
