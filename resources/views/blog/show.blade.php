<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $post->title }} | Fosterheirs Blog</title>
<meta name="description" content="{{ $post->excerpt ?? $post->title }}">
<link rel="canonical" href="{{ route('blog.show', $post) }}">

<meta property="og:type" content="article">
<meta property="og:site_name" content="Fosterheirs">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->excerpt ?? $post->title }}">
@if($post->cover_image)
    <meta property="og:image" content="{{ $post->cover_image }}">
@endif
<meta property="og:url" content="{{ route('blog.show', $post) }}">
<meta name="twitter:card" content="summary_large_image">

<script type="application/ld+json">
{!! json_encode(array_filter([
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $post->title,
    'description' => $post->excerpt ?? $post->title,
    'url' => route('blog.show', $post),
    'datePublished' => $post->published_at?->toIso8601String(),
    'dateModified' => $post->updated_at->toIso8601String(),
    'image' => $post->cover_image ?: null,
    'articleSection' => $post->category ?: null,
    'author' => ['@type' => 'Organization', 'name' => 'Fosterheirs Mental Health Consultancy'],
    'publisher' => ['@type' => 'Organization', 'name' => 'Fosterheirs Mental Health Consultancy'],
]), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

<script src="https://unpkg.com/lucide@latest"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">

@include('partials.site-header')

<main>
<section class="bg-slate-50 pb-14 pt-32 sm:pt-40">
  <div class="mx-auto max-w-4xl px-5 lg:px-8">
    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-emerald-700">
      <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to blog
    </a>

    <div class="mt-6 flex flex-wrap items-center gap-3">
      @if($post->category)
        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700">{{ $post->category }}</span>
      @endif
      <span class="text-xs text-slate-400">{{ $post->read_time }} min read</span>
      @if($post->published_at)
        <span class="text-xs text-slate-400">{{ $post->published_at->format('M j, Y') }}</span>
      @endif
      @if($post->views > 0)
        <span class="text-xs text-slate-400">{{ number_format($post->views) }} views</span>
      @endif
    </div>

    <h1 class="mt-4 text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl">{{ $post->title }}</h1>

    @if($post->excerpt)
      <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600">{{ $post->excerpt }}</p>
    @endif

    @if(!empty($post->tags))
      <div class="mt-5 flex flex-wrap gap-2">
        @foreach($post->tags as $tag)
          <span class="rounded-full bg-white border border-slate-200 px-2.5 py-1 text-[11px] font-medium text-slate-500">{{ $tag }}</span>
        @endforeach
      </div>
    @endif
  </div>
</section>

<div class="mx-auto max-w-7xl px-5 py-14 lg:px-8">
  <div class="grid gap-14 lg:grid-cols-[1fr_300px]">

    <article class="min-w-0">
      @if($post->cover_image)
        <div class="mb-8 overflow-hidden rounded-2xl border border-slate-200">
          <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full object-cover" style="max-height:420px">
        </div>
      @endif

      @if($post->content)
        <div class="blog-content">
          {!! \App\Helpers\ContentHelper::render($post->content) !!}
        </div>
      @else
        <p class="text-sm text-slate-400">Content coming soon.</p>
      @endif

      @if($post->external_link)
        <div class="mt-8 flex items-center gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-5">
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
            <i data-lucide="link-2" class="h-4 w-4"></i>
          </div>
          <div class="min-w-0 flex-1">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Referenced link</p>
            <a href="{{ $post->external_link }}" target="_blank" rel="noopener" class="break-all text-sm text-emerald-700 underline underline-offset-2">{{ $post->external_link }}</a>
          </div>
          <a href="{{ $post->external_link }}" target="_blank" rel="noopener"
             class="inline-flex shrink-0 items-center gap-1.5 rounded-lg bg-emerald-700 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-emerald-800">
            <i data-lucide="external-link" class="h-3 w-3"></i> Visit link
          </a>
        </div>
      @endif

      {{-- ============ COMMENTS ============ --}}
      <div id="comments" class="mt-14 flex flex-col gap-6">
        <div class="flex items-center gap-3">
          <div class="h-px flex-1 bg-slate-100"></div>
          <span id="comment-count-pill" class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
            {{ $comments->total() }} {{ Str::plural('comment', $comments->total()) }}
          </span>
          <div class="h-px flex-1 bg-slate-100"></div>
        </div>

        <div id="comment-flash" class="items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" style="{{ session('success') ? 'display:flex;' : 'display:none;' }}">
          <i data-lucide="check-circle" class="h-4 w-4 shrink-0"></i>
          <span id="comment-flash-text">{{ session('success') ?? 'Comment posted.' }}</span>
        </div>

        <form id="comment-form" method="POST" action="{{ route('blog.comments.store', $post) }}" class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-5 sm:p-6">
            @csrf
            <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden" aria-hidden="true">
              <label for="website">Leave this field empty</label>
              <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
            </div>

            <input type="text" name="author_name" id="comment-author" maxlength="80" value="{{ old('author_name') }}"
                   placeholder="Name (optional)"
                   class="w-full max-w-xs rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">

            <textarea name="body" id="comment-body" rows="3" required minlength="2" maxlength="2000"
                      placeholder="Share your thoughts..."
                      class="w-full rounded-lg border border-slate-200 px-3.5 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-1 focus:ring-emerald-600">{{ old('body') }}</textarea>
            <p id="comment-body-error" class="text-xs text-red-600" style="{{ $errors->has('body') ? 'display:block;' : 'display:none;' }}">{{ $errors->first('body') }}</p>

            <div class="flex flex-wrap items-center justify-between gap-3">
              <p class="text-xs text-slate-400">No account needed. Be kind.</p>
              <button type="submit" id="comment-submit-btn" class="inline-flex items-center gap-2 rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800">
                <span id="comment-submit-label">Post comment</span> <i data-lucide="send" class="h-3.5 w-3.5"></i>
              </button>
            </div>
        </form>

        <div id="comment-list" class="flex flex-col gap-4" style="{{ $comments->count() ? '' : 'display:none;' }}">
          @foreach($comments as $comment)
            <div class="flex gap-3.5">
              <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-600 to-emerald-800 text-xs font-bold text-white">
                {{ strtoupper(substr($comment->display_name, 0, 1)) }}
              </div>
              <div class="min-w-0 flex-1 rounded-xl border border-slate-100 bg-slate-50 p-4">
                <div class="flex flex-wrap items-center gap-2">
                  <span class="text-sm font-semibold text-slate-900">{{ $comment->display_name }}</span>
                  <span class="text-[11px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="mt-1 text-sm leading-relaxed text-slate-600" style="white-space:pre-line">{{ $comment->body }}</p>
              </div>
            </div>
          @endforeach
        </div>

        <div>{{ $comments->links() }}</div>

        <div id="comment-empty-state" class="py-8 text-center" style="{{ $comments->count() ? 'display:none;' : '' }}">
          <i data-lucide="message-circle" class="mx-auto h-7 w-7 text-slate-300"></i>
          <p class="mt-2 text-sm text-slate-400">No comments yet. Be the first to share your thoughts.</p>
        </div>
      </div>

      @if($related->count())
        <div class="mt-14 flex flex-col gap-5">
          <div class="flex items-center gap-3">
            <div class="h-px w-10 bg-emerald-200"></div>
            <span class="text-xs font-bold uppercase tracking-wide text-emerald-700">More like this</span>
          </div>
          <div class="grid gap-4 sm:grid-cols-3">
            @foreach($related as $r)
              <a href="{{ route('blog.show', $r) }}" class="flex flex-col rounded-2xl border border-slate-200 bg-white p-4 transition hover:shadow-md">
                @if($r->category)
                  <span class="w-fit rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-emerald-700">{{ $r->category }}</span>
                @endif
                <h4 class="mt-2 flex-1 text-sm font-bold leading-snug text-slate-900">{{ Str::limit($r->title, 65) }}</h4>
                <div class="mt-3 flex items-center justify-between border-t border-slate-50 pt-2">
                  <span class="text-[11px] text-slate-400">{{ $r->read_time }} min read</span>
                  <span class="text-[11px] font-semibold text-emerald-700">Read &rarr;</span>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </article>

    <aside class="flex flex-col gap-5 lg:sticky lg:top-28 lg:h-fit">
      <div class="rounded-2xl border border-slate-200 bg-white p-5 flex flex-col gap-4">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">About Fosterheirs</p>
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/brand/logo-mark.png') }}" alt="Fosterheirs" class="h-11 w-11 object-contain">
          <div>
            <p class="text-sm font-bold text-slate-900">Fosterheirs Team</p>
            <p class="text-xs text-slate-500">Mental Health Consultancy</p>
          </div>
        </div>
        <a href="{{ route('home') }}#contact" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-emerald-800">
          Book a Session <i data-lucide="arrow-right" class="h-3 w-3"></i>
        </a>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white p-5 flex flex-col gap-2">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400 mb-1">Share this post</p>
        <button onclick="shareBlogPost('whatsapp')" class="share-btn">@include('partials.social-icon', ['platform' => 'whatsapp', 'class' => 'h-3.5 w-3.5']) WhatsApp</button>
        <button onclick="shareBlogPost('twitter')" class="share-btn">@include('partials.social-icon', ['platform' => 'twitter', 'class' => 'h-3.5 w-3.5']) Twitter / X</button>
        <button onclick="shareBlogPost('facebook')" class="share-btn">@include('partials.social-icon', ['platform' => 'facebook', 'class' => 'h-3.5 w-3.5']) Facebook</button>
        <div class="h-px bg-slate-100 my-1"></div>
        <button onclick="shareBlogPost('copy', this)" class="share-btn"><i data-lucide="link" class="h-3.5 w-3.5"></i> Copy link</button>
      </div>

      <div class="rounded-2xl border border-slate-200 bg-white p-5 flex flex-col gap-3">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Post Info</p>
        @if($post->published_at)
          <div class="flex items-center justify-between text-xs">
            <span class="text-slate-500">Published</span>
            <span class="font-medium text-slate-700">{{ $post->published_at->format('M j, Y') }}</span>
          </div>
        @endif
        <div class="flex items-center justify-between text-xs">
          <span class="text-slate-500">Read time</span>
          <span class="font-medium text-slate-700">{{ $post->read_time }} min</span>
        </div>
        @if($post->views > 0)
          <div class="flex items-center justify-between text-xs">
            <span class="text-slate-500">Views</span>
            <span class="font-medium text-slate-700">{{ number_format($post->views) }}</span>
          </div>
        @endif
      </div>
    </aside>

  </div>
</div>
</main>

@include('partials.site-footer')

<style>
    .share-btn { display:flex; align-items:center; gap:.6rem; padding:.55rem .7rem; border-radius:.6rem; font-size:.85rem; color:#475569; background:#f8fafc; border:1px solid #e2e8f0; transition:.15s; text-align:left; }
    .share-btn:hover { background:#f0fdf4; border-color:#a7f3d0; color:#047857; }

    .blog-content { color: #334155; font-size: 1rem; line-height: 1.75; }
    .blog-content p { margin-top: 1.25rem; }
    .blog-content p:first-child { margin-top: 0; }
    .blog-content h2 { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-top: 2.5rem; margin-bottom: .75rem; }
    .blog-content h3 { font-size: 1.2rem; font-weight: 700; color: #0f172a; margin-top: 2rem; margin-bottom: .5rem; }
    .blog-content a { color: #047857; text-decoration: underline; text-underline-offset: 2px; }
    .blog-content strong { font-weight: 700; color: #0f172a; }
    .blog-content ul, .blog-content ol { margin: 1.25rem 0; padding-left: 1.5rem; }
    .blog-content ul { list-style: disc; }
    .blog-content ol { list-style: decimal; }
    .blog-content li { margin-top: .4rem; }
    .blog-content blockquote { margin: 1.75rem 0; padding: .25rem 1.25rem; border-left: 3px solid #059669; color: #475569; font-style: italic; }
    .blog-content pre { margin: 1.5rem 0; padding: 1rem; border-radius: .75rem; background: #0f172a; color: #e2e8f0; overflow-x: auto; font-size: .85rem; }
    .blog-content code { background: #f1f5f9; padding: .15rem .4rem; border-radius: .35rem; font-size: .875em; }
    .blog-content pre code { background: none; padding: 0; }
    .blog-content hr { margin: 2.5rem 0; border-color: #e2e8f0; }
    .blog-content img { border-radius: .75rem; margin: 1.5rem 0; max-width: 100%; }
</style>

<script>
function shareBlogPost(platform, el = null) {
  const url = encodeURIComponent(window.location.href);
  const title = encodeURIComponent(@json($post->title));
  const urls = {
    twitter: `https://twitter.com/intent/tweet?text=${title}&url=${url}`,
    whatsapp: `https://wa.me/?text=${title}%20${url}`,
    facebook: `https://www.facebook.com/sharer/sharer.php?u=${url}`,
  };

  if (platform === 'copy') {
    const btn = el;
    const orig = btn.innerHTML;
    const showCopied = () => {
      btn.innerHTML = '<i data-lucide="check" class="h-3.5 w-3.5"></i> Copied!';
      if (window.lucide) lucide.createIcons();
      setTimeout(() => { btn.innerHTML = orig; if (window.lucide) lucide.createIcons(); }, 2000);
    };
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(window.location.href).then(showCopied);
    }
    return;
  }

  window.open(urls[platform], '_blank', 'noopener,width=600,height=480');
}

(function() {
  const form = document.getElementById('comment-form');
  if (!form) return;

  const submitBtn = document.getElementById('comment-submit-btn');
  const submitLabel = document.getElementById('comment-submit-label');
  const bodyError = document.getElementById('comment-body-error');
  const list = document.getElementById('comment-list');
  const emptyState = document.getElementById('comment-empty-state');
  const countPill = document.getElementById('comment-count-pill');
  const flash = document.getElementById('comment-flash');
  const flashText = document.getElementById('comment-flash-text');
  let flashTimer = null;

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  function showFlash(message) {
    flashText.textContent = message;
    flash.style.display = 'flex';
    clearTimeout(flashTimer);
    flashTimer = setTimeout(() => { flash.style.display = 'none'; }, 4000);
  }

  function bumpCount(delta) {
    const current = parseInt((countPill.textContent.match(/\d+/) || [0])[0], 10);
    const next = Math.max(0, current + delta);
    countPill.textContent = next + ' ' + (next === 1 ? 'comment' : 'comments');
  }

  function prependComment(comment) {
    const row = document.createElement('div');
    row.className = 'flex gap-3.5';
    row.style.opacity = '0';
    row.style.transition = 'opacity .35s ease';
    row.innerHTML = `
      <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-emerald-600 to-emerald-800 text-xs font-bold text-white">${escapeHtml(comment.initial)}</div>
      <div class="min-w-0 flex-1 rounded-xl border border-slate-100 bg-slate-50 p-4">
        <div class="flex flex-wrap items-center gap-2">
          <span class="text-sm font-semibold text-slate-900">${escapeHtml(comment.display_name)}</span>
          <span class="text-[11px] text-slate-400">${escapeHtml(comment.created_at)}</span>
        </div>
        <p class="mt-1 text-sm leading-relaxed text-slate-600" style="white-space:pre-line">${escapeHtml(comment.body)}</p>
      </div>
    `;
    list.style.display = 'flex';
    list.prepend(row);
    emptyState.style.display = 'none';
    requestAnimationFrame(() => { row.style.opacity = '1'; });
  }

  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    bodyError.style.display = 'none';
    submitBtn.disabled = true;
    submitLabel.textContent = 'Posting...';

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const formData = new FormData(form);

    try {
      const res = await fetch(form.action, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token },
        body: formData,
      });

      if (res.status === 422) {
        const data = await res.json();
        bodyError.textContent = data.errors?.body?.[0] || 'Please check your comment and try again.';
        bodyError.style.display = 'block';
        return;
      }
      if (!res.ok) throw new Error('Request failed');

      const data = await res.json();
      if (data.comment) {
        prependComment(data.comment);
        bumpCount(1);
      }
      showFlash('Comment posted.');
      form.reset();
    } catch (err) {
      bodyError.textContent = 'Something went wrong. Please try again.';
      bodyError.style.display = 'block';
    } finally {
      submitBtn.disabled = false;
      submitLabel.textContent = 'Post comment';
    }
  });
})();
</script>

<script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}"></script>
</body>
</html>
