@extends('layouts.admin')

@section('title', 'Course Categories')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-3xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Course Categories</h2>
        <p class="mt-1 text-sm text-gray-600">Group courses so students can browse by category on the storefront.</p>
    </div>

    <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 mb-6">
        <h3 class="text-sm font-semibold text-gray-900 mb-3">Add a Category</h3>
        <form method="POST" action="{{ route('admin.courses.categories.store') }}" class="flex items-center gap-2">
            @csrf
            <input type="text" name="name" required value="{{ old('name') }}" placeholder="e.g., Heirs Certification Courses"
                class="flex-1 px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name') border-red-400 @else border-gray-300 @enderror">
            <button type="submit" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition whitespace-nowrap">
                Add Category
            </button>
        </form>
        @error('name')
            <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Name</th>
                    <th class="text-left px-5 py-3">Courses</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 font-semibold text-gray-900">{{ $category->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $category->courses_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('admin.courses.categories.destroy', $category) }}" class="inline"
                                  onsubmit="return confirm('Remove the &quot;{{ $category->name }}&quot; category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-5 py-12 text-center text-gray-400">No categories yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
