@extends('layouts.admin')

@section('title', 'Services')

@section('content')
<div class="flex-1">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Services</h2>
            <p class="mt-1 text-sm text-gray-600">Choose which services show in the homepage "Services &amp; Clinical Care" section.</p>
        </div>
        <a href="{{ route('admin.services.create') }}"
            class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 text-sm font-semibold">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Service
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Service</th>
                    <th class="text-left px-5 py-3">Description</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($services as $service)
                    <tr class="hover:bg-gray-50 align-top">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center flex-shrink-0">
                                    <i data-lucide="{{ $service->icon }}" class="w-4 h-4"></i>
                                </div>
                                <span class="font-semibold text-gray-900">{{ $service->title }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600 max-w-sm">{{ $service->description }}</td>
                        <td class="px-5 py-3">
                            @if($service->is_visible)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Shown</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">Hidden</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.services.toggle', $service) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold {{ $service->is_visible ? 'text-gray-500 hover:text-gray-800' : 'text-emerald-700 hover:text-emerald-900' }} mr-3">
                                    {{ $service->is_visible ? 'Hide' : 'Show' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-3">Edit</a>
                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="inline"
                                  onsubmit="return confirm('Remove &quot;{{ $service->title }}&quot;?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-gray-400">
                            No services yet. <a href="{{ route('admin.services.create') }}" class="text-emerald-600 font-semibold hover:underline">Add one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
