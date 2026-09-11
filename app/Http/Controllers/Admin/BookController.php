<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::ordered()->get();

        return view('admin.books.index', compact('books'));
    }

    public function create(): View
    {
        return view('admin.books.form', ['book' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBook($request);

        $validated['cover_image_path'] = $this->uploadCoverImage($request);
        $validated['sort_order'] = (Book::max('sort_order') ?? -1) + 1;
        $validated['is_visible'] = $request->boolean('is_visible', true);

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', "\"{$validated['title']}\" added.");
    }

    public function edit(Book $book): View
    {
        return view('admin.books.form', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $this->validateBook($request);
        $validated['is_visible'] = $request->boolean('is_visible', true);

        if ($request->hasFile('cover_image')) {
            app(CloudinaryService::class)->delete($book->cover_image_path);
            $validated['cover_image_path'] = $this->uploadCoverImage($request);
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', "\"{$book->title}\" updated.");
    }

    public function destroy(Book $book): RedirectResponse
    {
        app(CloudinaryService::class)->delete($book->cover_image_path);
        $book->delete();

        return back()->with('success', 'Book removed.');
    }

    public function toggle(Book $book): RedirectResponse
    {
        $book->update(['is_visible' => ! $book->is_visible]);

        return back()->with(
            'success',
            $book->is_visible ? "\"{$book->title}\" is now shown on the site." : "\"{$book->title}\" is now hidden from the site."
        );
    }

    private function validateBook(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'blurb' => ['nullable', 'string', 'max:1000'],
            'link_url' => ['nullable', 'url', 'max:2048'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function uploadCoverImage(Request $request): ?string
    {
        if (! $request->hasFile('cover_image')) {
            return null;
        }

        return app(CloudinaryService::class)->upload($request->file('cover_image'), 'books');
    }
}
