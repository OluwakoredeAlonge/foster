@extends('layouts.admin')

@section('title', 'Pulled Courses')

@section('content')
<div class="flex-1">
    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Pulled Courses</h2>
        <p class="mt-1 text-sm text-gray-600">
            Courses pulled live from the partner courses API. Hide anything Dr. Soje doesn't want featured on the
            Fosterheirs homepage &mdash; hiding a course here only affects this site, it stays live on the partner's
            own storefront.
        </p>
    </div>

    @if($error)
        <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-5 mb-6">
            <i data-lucide="alert-circle" class="mt-0.5 h-5 w-5 shrink-0 text-red-600"></i>
            <p class="text-sm text-red-800">{{ $error }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Course</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Price</th>
                    <th class="text-left px-5 py-3">Visibility</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($courses as $course)
                    @php
                        $isHidden = isset($hidden[$course['slug']]);
                        $isImported = in_array($course['slug'], $importedSlugs, true);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if(!empty($course['image_url']))
                                        <img src="{{ $course['image_url'] }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="graduation-cap" class="w-5 h-5 text-gray-400"></i>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{ $course['purchase_url'] ?? '#' }}" target="_blank" class="font-semibold text-gray-900 hover:text-emerald-700 hover:underline">
                                        {{ $course['title'] }}
                                    </a>
                                    <p class="text-xs text-gray-400 font-mono">{{ $course['slug'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $course['category']['name'] ?? $course['type'] ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-700">
                            @if(is_numeric($course['price'] ?? null))
                                ₦{{ number_format($course['price'], 0) }}
                            @else
                                &mdash;
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if($isHidden)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">Hidden</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Shown</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-3">
                                @if($isImported)
                                    <span class="text-xs font-semibold text-emerald-700 flex items-center gap-1">
                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                                        Imported
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('admin.external-courses.import', $course['slug']) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold text-blue-600 hover:text-blue-800"
                                            onclick="return confirm('Import this course into the local database? It becomes a fully independent course you can edit under Course Platform > Courses, and will be hidden from this pulled-courses feed.')">
                                            Import to Fosterheirs
                                        </button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.external-courses.toggle', $course['slug']) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold {{ $isHidden ? 'text-emerald-700 hover:text-emerald-900' : 'text-red-600 hover:text-red-800' }}">
                                        {{ $isHidden ? 'Show on site' : 'Hide from site' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            @if($error)
                                Couldn't load courses from the partner API.
                            @else
                                No courses have been published on the partner site yet.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
