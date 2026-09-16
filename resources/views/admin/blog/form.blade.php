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

                    <div x-data="richEditor()" x-init="init()">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Content</label>
                        <p class="text-xs text-gray-400 mb-2">Select text, then click a button to format it — just like Word. What you see here is what visitors will see.</p>

                        <div class="flex flex-wrap items-center gap-1 p-2 rounded-t-xl border border-b-0 border-gray-300 bg-gray-50">
                            <button type="button" @mousedown.prevent="cmd('bold')" title="Bold" class="editor-btn font-bold">B</button>
                            <button type="button" @mousedown.prevent="cmd('italic')" title="Italic" class="editor-btn italic">I</button>
                            <button type="button" @mousedown.prevent="cmd('underline')" title="Underline" class="editor-btn underline">U</button>
                            <div class="w-px h-5 bg-gray-300 mx-1"></div>
                            <button type="button" @mousedown.prevent="cmd('formatBlock', 'h2')" title="Heading 2" class="editor-btn">H2</button>
                            <button type="button" @mousedown.prevent="cmd('formatBlock', 'h3')" title="Heading 3" class="editor-btn">H3</button>
                            <button type="button" @mousedown.prevent="cmd('formatBlock', 'p')" title="Paragraph" class="editor-btn">P</button>
                            <div class="w-px h-5 bg-gray-300 mx-1"></div>
                            <button type="button" @mousedown.prevent="insertLink()" title="Insert link" class="editor-btn flex items-center gap-1 text-emerald-700">
                                <i data-lucide="link" class="w-3 h-3"></i> Link
                            </button>
                            <button type="button" @mousedown.prevent="cmd('formatBlock', 'blockquote')" title="Blockquote" class="editor-btn">&ldquo;</button>
                            <button type="button" @mousedown.prevent="cmd('insertUnorderedList')" title="Bullet list" class="editor-btn">UL</button>
                            <button type="button" @mousedown.prevent="cmd('insertOrderedList')" title="Numbered list" class="editor-btn">OL</button>
                            <div class="w-px h-5 bg-gray-300 mx-1"></div>
                            <button type="button" @mousedown.prevent="cmd('insertHorizontalRule')" title="Divider" class="editor-btn">—</button>
                            <button type="button" @mousedown.prevent="cmd('removeFormat')" title="Clear formatting" class="editor-btn text-gray-400">Clear</button>
                        </div>

                        <div x-ref="editor" contenteditable="true"
                             class="rich-editor-content w-full px-4 py-3 border border-gray-300 rounded-b-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm leading-relaxed"
                             style="min-height: 22rem" @input="sync()" @blur="sync()"></div>

                        <textarea name="content" x-ref="hidden" class="hidden">{{ old('content', $post->content ?? '') }}</textarea>
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
    .editor-btn:disabled { opacity: .4; cursor: not-allowed; }

    /* Mirrors .blog-content on the public post page so what she sees while
       typing matches what visitors actually see. */
    .rich-editor-content { color: #334155; }
    .rich-editor-content:focus { outline: none; }
    .rich-editor-content p { margin-top: 1rem; }
    .rich-editor-content p:first-child { margin-top: 0; }
    .rich-editor-content h2 { font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-top: 1.5rem; margin-bottom: .5rem; }
    .rich-editor-content h3 { font-size: 1.1rem; font-weight: 700; color: #0f172a; margin-top: 1.25rem; margin-bottom: .4rem; }
    .rich-editor-content a { color: #047857; text-decoration: underline; }
    .rich-editor-content ul, .rich-editor-content ol { margin: 1rem 0; padding-left: 1.5rem; }
    .rich-editor-content ul { list-style: disc; }
    .rich-editor-content ol { list-style: decimal; }
    .rich-editor-content blockquote { margin: 1.25rem 0; padding: .25rem 1rem; border-left: 3px solid #059669; color: #475569; font-style: italic; }
    .rich-editor-content hr { margin: 1.5rem 0; border-color: #e2e8f0; }
</style>

<script>
    function richEditor() {
        return {
            init() {
                try { document.execCommand('defaultParagraphSeparator', false, 'p'); } catch (e) {}

                const initial = this.$refs.hidden.value.trim();
                if (!initial) return;

                // Existing posts saved before this editor existed may just be
                // plain text (no tags) — wrap it into paragraphs so it's
                // editable the same way instead of showing as one unbroken block.
                this.$refs.editor.innerHTML = /<[a-z][\s\S]*>/i.test(initial)
                    ? initial
                    : initial.split(/\n{2,}/).filter(p => p.trim() !== '').map(p => `<p>${p.replace(/\n/g, '<br>')}</p>`).join('');
            },

            sync() {
                this.$refs.hidden.value = this.$refs.editor.innerHTML;
            },

            cmd(command, value = null) {
                this.$refs.editor.focus();
                document.execCommand(command, false, value);
                this.sync();
            },

            insertLink() {
                const hasSelection = (window.getSelection()?.toString() ?? '').trim() !== '';
                const url = prompt('Enter URL:', 'https://');
                if (!url) return;
                this.$refs.editor.focus();
                if (hasSelection) {
                    document.execCommand('createLink', false, url);
                } else {
                    const text = prompt('Link text:', url) || url;
                    document.execCommand('insertHTML', false, `<a href="${url.replace(/"/g, '&quot;')}" target="_blank" rel="noopener noreferrer">${text.replace(/</g, '&lt;')}</a>`);
                }
                this.sync();
            },
        };
    }

    // Belt-and-braces: guarantee the hidden field has the editor's latest
    // HTML even if a click went straight from the editor to "Save Post"
    // without a blur event reaching @blur="sync()" first.
    document.addEventListener('submit', (e) => {
        e.target.querySelectorAll?.('.rich-editor-content')?.forEach((editor) => {
            const hidden = editor.parentElement?.querySelector('textarea[name="content"]');
            if (hidden) hidden.value = editor.innerHTML;
        });
    }, true);
</script>
@endsection
