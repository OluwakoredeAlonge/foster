@extends('layouts.admin')

@section('title', $post ? 'Edit Post' : 'Write Post')

@section('content')
<div class="flex-1 max-w-5xl">
    <a href="{{ route('admin.blog.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Blog
    </a>

    <form method="POST" action="{{ $post ? route('admin.blog.update', $post) : route('admin.blog.store') }}"
          enctype="multipart/form-data" x-data="{ imagePreview: null }">
        @csrf
        @if($post) @method('PUT') @endif

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 flex flex-col gap-5">

                {{-- Cover image --}}
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Cover Image <span class="text-gray-400 font-normal">(optional)</span></label>

                    @if($post && $post->cover_image)
                        <img src="{{ $post->cover_image }}" class="w-full max-w-sm h-40 object-cover rounded-xl border border-gray-200 mb-3">
                        <label class="flex items-center gap-2 mb-3">
                            <input type="checkbox" name="remove_cover_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <span class="text-sm text-gray-600">Remove current cover image</span>
                        </label>
                    @endif

                    <div class="relative rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center gap-2 cursor-pointer transition hover:border-emerald-400 hover:bg-emerald-50/30"
                         style="min-height:140px"
                         @dragover.prevent="$el.classList.add('border-emerald-400','bg-emerald-50/30')"
                         @dragleave="$el.classList.remove('border-emerald-400','bg-emerald-50/30')"
                         @drop.prevent="
                            $el.classList.remove('border-emerald-400','bg-emerald-50/30');
                            const f = $event.dataTransfer.files[0];
                            if (f) {
                                $refs.coverInput.files = $event.dataTransfer.files;
                                const r = new FileReader(); r.onload = e => imagePreview = e.target.result; r.readAsDataURL(f);
                            }
                         "
                         @click="$refs.coverInput.click()">
                        <template x-if="!imagePreview">
                            <div class="flex flex-col items-center gap-2 pointer-events-none">
                                <i data-lucide="image-plus" class="w-7 h-7 text-gray-400"></i>
                                <p class="text-xs text-gray-500">Click or drag & drop an image (max 4MB)</p>
                            </div>
                        </template>
                        <template x-if="imagePreview">
                            <img :src="imagePreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                        </template>
                    </div>
                    <input type="file" name="cover_image" x-ref="coverInput" accept="image/jpeg,image/png,image/webp" class="hidden"
                           @change="const f = $event.target.files[0]; if (f) { const r = new FileReader(); r.onload = e => imagePreview = e.target.result; r.readAsDataURL(f); }">
                    @error('cover_image') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Core content --}}
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" required value="{{ old('title', $post->title ?? '') }}" placeholder="Understanding Trauma-Informed Care"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('title') border-red-400 @else border-gray-300 @enderror">
                        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Excerpt</label>
                        <textarea name="excerpt" rows="2" placeholder="Short summary shown in the article list..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    </div>

                    <div x-data="editorToolbar('content_area')">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Content <span class="text-gray-400 font-normal">(HTML supported)</span></label>

                        <div class="flex flex-wrap items-center gap-1 p-2 rounded-t-xl border border-b-0 border-gray-300 bg-gray-50">
                            <button type="button" @click="wrap('<strong>','</strong>')" title="Bold" class="editor-btn font-bold">B</button>
                            <button type="button" @click="wrap('<em>','</em>')" title="Italic" class="editor-btn italic">I</button>
                            <button type="button" @click="wrap('<code>','</code>')" title="Inline code" class="editor-btn font-mono text-xs">&lt;/&gt;</button>
                            <div class="w-px h-5 bg-gray-300 mx-1"></div>
                            <button type="button" @click="wrapBlock('<h2>','</h2>')" title="Heading 2" class="editor-btn">H2</button>
                            <button type="button" @click="wrapBlock('<h3>','</h3>')" title="Heading 3" class="editor-btn">H3</button>
                            <button type="button" @click="wrapBlock('<p>','</p>')" title="Paragraph" class="editor-btn">P</button>
                            <div class="w-px h-5 bg-gray-300 mx-1"></div>
                            <button type="button" @click="insertLink()" title="Insert link" class="editor-btn flex items-center gap-1 text-emerald-700">
                                <i data-lucide="link" class="w-3 h-3"></i> Link
                            </button>
                            <button type="button" @click="wrapBlock('<blockquote>','</blockquote>')" title="Blockquote" class="editor-btn">&ldquo;</button>
                            <button type="button" @click="wrap('\n<ul>\n  <li>','</li>\n</ul>')" title="Bullet list" class="editor-btn">UL</button>
                            <button type="button" @click="wrap('\n<ol>\n  <li>','</li>\n</ol>')" title="Numbered list" class="editor-btn">OL</button>
                            <div class="w-px h-5 bg-gray-300 mx-1"></div>
                            <button type="button" @click="insertHr()" title="Divider" class="editor-btn">—</button>
                        </div>

                        <textarea name="content" id="content_area" rows="18" placeholder="Write your article here..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-b-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-mono text-sm leading-relaxed">{{ old('content', $post->content ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-5">
                {{-- Publish settings --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 flex flex-col gap-4">
                    <p class="text-sm font-semibold text-gray-700">Publish Settings</p>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-500 mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-500 mb-1.5">Publish Date</label>
                        <input type="datetime-local" name="published_at"
                            value="{{ old('published_at', optional($post->published_at ?? null)->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                        <p class="text-xs text-gray-400 mt-1">Defaults to now when first published.</p>
                    </div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="featured" value="1" {{ old('featured', $post->featured ?? false) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-sm text-gray-700">Featured post</span>
                    </label>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-500 mb-1.5">Read Time (minutes)</label>
                        <input type="number" name="read_time" min="1" value="{{ old('read_time', $post->read_time ?? 5) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                </div>

                {{-- Metadata --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 flex flex-col gap-4">
                    <p class="text-sm font-semibold text-gray-700">Metadata</p>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-500 mb-1.5">Category</label>
                        <input type="text" name="category" value="{{ old('category', $post->category ?? '') }}" placeholder="Trauma Healing"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase text-gray-500 mb-1.5">Tags <span class="text-gray-400 font-normal normal-case">comma-separated</span></label>
                        <input type="text" name="tags" value="{{ old('tags', isset($post) && $post ? implode(', ', $post->tags ?? []) : '') }}" placeholder="Trauma, Faith, Recovery"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    </div>
                </div>

                {{-- External link --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 flex flex-col gap-2">
                    <label class="block text-sm font-semibold text-gray-700">External Link <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="url" name="external_link" value="{{ old('external_link', $post->external_link ?? '') }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('external_link') border-red-400 @enderror">
                    @error('external_link') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400">Shown as a button on the post page. Opens in a new tab.</p>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 justify-center px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i> Save Post
                    </button>
                    <a href="{{ route('admin.blog.index') }}" class="px-5 py-3 border border-gray-300 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .editor-btn { padding: .35rem .55rem; border-radius: .5rem; font-size: .75rem; color: #374151; }
    .editor-btn:hover { background: #e5e7eb; }
</style>

<script>
    function editorToolbar(textareaId) {
        return {
            get ta() { return document.getElementById(textareaId); },

            wrap(open, close) {
                const ta = this.ta;
                const start = ta.selectionStart, end = ta.selectionEnd;
                const sel = ta.value.slice(start, end);
                const replacement = open + (sel || 'text') + close;
                ta.setRangeText(replacement, start, end, 'select');
                if (start === end) {
                    ta.selectionStart = start + open.length;
                    ta.selectionEnd = start + open.length + (sel || 'text').length;
                }
                ta.focus();
            },

            wrapBlock(open, close) {
                const ta = this.ta;
                const start = ta.selectionStart, end = ta.selectionEnd;
                const sel = ta.value.slice(start, end).trim() || 'Your text here';
                const replacement = '\n' + open + sel + close + '\n';
                ta.setRangeText(replacement, start, end, 'end');
                ta.focus();
            },

            insertLink() {
                const ta = this.ta;
                const start = ta.selectionStart, end = ta.selectionEnd;
                const selText = ta.value.slice(start, end).trim();
                const url = prompt('Enter URL:', 'https://');
                if (!url) return;
                const text = selText || prompt('Link text:', url) || url;
                const tag = `<a href="${url}" target="_blank" rel="noopener noreferrer">${text}</a>`;
                ta.setRangeText(tag, start, end, 'end');
                ta.focus();
            },

            insertHr() {
                const ta = this.ta;
                const pos = ta.selectionEnd;
                ta.setRangeText('\n<hr>\n', pos, pos, 'end');
                ta.focus();
            },
        };
    }
</script>
@endsection
