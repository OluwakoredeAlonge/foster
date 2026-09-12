@extends('layouts.admin')

@section('title', 'Landing Page')

@php
    // After a failed submit, prefer old() so nothing the admin just typed
    // is lost — same reasoning as the course form's weeks/resources.
    $statsData = old('stats', $settings->stats ?: []);
    $pillarsData = old('about_pillars', $settings->about_pillars ?: []);
    $programsData = old('organization_programs', $settings->organization_programs ?: []);
@endphp

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-4xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Landing Page</h2>
        <p class="mt-1 text-sm text-gray-600">Edit every piece of copy and imagery on the homepage — hero, about, impact stats, and the speaking-invitation banner.</p>
    </div>

    <form method="POST" action="{{ route('admin.landing-page.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Hero --}}
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Hero Section</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Badge Text</label>
                    <input type="text" name="hero_badge_text" value="{{ old('hero_badge_text', $settings->hero_badge_text) }}"
                        class="w-full max-w-md px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Headline</label>
                    <input type="text" name="hero_headline" value="{{ old('hero_headline', $settings->hero_headline) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Headline (highlighted word/phrase)</label>
                    <input type="text" name="hero_headline_highlight" value="{{ old('hero_headline_highlight', $settings->hero_headline_highlight) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Shown in amber right after the headline, e.g. "Renewing Hope."</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Subheadline</label>
                    <textarea name="hero_subheadline" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('hero_subheadline', $settings->hero_subheadline) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Primary Button Text</label>
                    <input type="text" name="hero_primary_cta_text" value="{{ old('hero_primary_cta_text', $settings->hero_primary_cta_text) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Links to the contact section.</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Secondary Button Text</label>
                    <input type="text" name="hero_secondary_cta_text" value="{{ old('hero_secondary_cta_text', $settings->hero_secondary_cta_text) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Links to Our Therapists.</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Background Image</label>
                    @if($settings->hero_image_path)
                        <img src="{{ $settings->hero_image_path }}" class="w-full max-w-xs h-32 object-cover rounded-lg border border-gray-200 mb-2">
                    @endif
                    <input type="file" name="hero_image" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm file:font-semibold hover:file:bg-emerald-100">
                    @error('hero_image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Max 4MB. Leave blank to keep the current image.</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200" x-data="{
            stats: @js(array_values($statsData)),
            add() { this.stats.push({ value: '', suffix: '+', label: '' }) },
            remove(i) { this.stats.splice(i, 1) },
        }">
            <div class="flex items-center justify-between mb-1">
                <h3 class="text-lg font-semibold text-gray-900">Impact Stats</h3>
                <button type="button" @click="add()" class="text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-lg transition flex-shrink-0">
                    + Add Stat
                </button>
            </div>
            <p class="text-xs text-gray-500 mb-4">Shown as animated counters in the hero band and again in the "Our Impact" section further down.</p>

            <div class="space-y-3">
                <template x-for="(stat, i) in stats" :key="i">
                    <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                        <div class="grid grid-cols-3 gap-2 flex-1">
                            <div>
                                <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Number</label>
                                <input type="text" :name="`stats[${i}][value]`" x-model="stat.value" placeholder="18"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Suffix</label>
                                <input type="text" :name="`stats[${i}][suffix]`" x-model="stat.suffix" placeholder="+"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Label</label>
                                <input type="text" :name="`stats[${i}][label]`" x-model="stat.label" placeholder="Addicts Rehabilitated"
                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            </div>
                        </div>
                        <button type="button" @click="remove(i)" class="mt-6 text-gray-400 hover:text-red-600">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </template>
                <p x-show="stats.length === 0" class="text-sm text-gray-400 text-center py-4">No stats yet. Click "Add Stat" to create one.</p>
            </div>
        </div>

        {{-- About --}}
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">About Section</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Eyebrow</label>
                    <input type="text" name="about_eyebrow" value="{{ old('about_eyebrow', $settings->about_eyebrow) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Heading</label>
                    <input type="text" name="about_heading" value="{{ old('about_heading', $settings->about_heading) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Paragraph</label>
                    <textarea name="about_paragraph" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('about_paragraph', $settings->about_paragraph) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Quote</label>
                    <textarea name="about_quote" rows="2"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('about_quote', $settings->about_quote) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Quote Citation</label>
                    <input type="text" name="about_quote_citation" value="{{ old('about_quote_citation', $settings->about_quote_citation) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Photo</label>
                    @if($settings->about_image_path)
                        <img src="{{ $settings->about_image_path }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200 mb-2">
                    @endif
                    <input type="file" name="about_image" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm file:font-semibold hover:file:bg-emerald-100">
                    @error('about_image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Max 4MB. Leave blank to keep the current photo.</p>
                </div>
            </div>

            <div class="mt-5 pt-5 border-t border-gray-100" x-data="{
                pillars: @js(array_values($pillarsData)),
                add() { this.pillars.push({ icon: '', label: '' }) },
                remove(i) { this.pillars.splice(i, 1) },
            }">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-sm font-semibold text-gray-700">Approach Cards</p>
                    <button type="button" @click="add()" class="text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-lg transition flex-shrink-0">
                        + Add Card
                    </button>
                </div>
                <p class="text-xs text-gray-500 mb-4">The small icon cards under the about paragraph (e.g. "Medical Intervention").</p>

                <div class="space-y-3">
                    <template x-for="(pillar, i) in pillars" :key="i">
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                            <div class="grid grid-cols-2 gap-2 flex-1">
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Icon</label>
                                    <input type="text" :name="`about_pillars[${i}][icon]`" x-model="pillar.icon" placeholder="stethoscope"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Label</label>
                                    <input type="text" :name="`about_pillars[${i}][label]`" x-model="pillar.label" placeholder="Medical Intervention"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                </div>
                            </div>
                            <button type="button" @click="remove(i)" class="mt-6 text-gray-400 hover:text-red-600">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </template>
                    <p x-show="pillars.length === 0" class="text-sm text-gray-400 text-center py-4">No cards yet.</p>
                </div>
                <p class="text-xs text-gray-400 mt-3">Icon names come from <a href="https://lucide.dev/icons" target="_blank" rel="noopener" class="underline hover:text-emerald-700">lucide.dev/icons</a> — type the icon's name exactly as shown there, e.g. "brain" or "heart-handshake".</p>
            </div>
        </div>

        {{-- Speaking banner --}}
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Speaking Invitation Banner</h3>
            <p class="text-xs text-gray-500 -mt-3 mb-4">The dark banner at the bottom of the Services section.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Heading</label>
                    <input type="text" name="services_banner_heading" value="{{ old('services_banner_heading', $settings->services_banner_heading) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Button Text</label>
                    <input type="text" name="services_banner_cta_text" value="{{ old('services_banner_cta_text', $settings->services_banner_cta_text) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Text</label>
                    <textarea name="services_banner_text" rows="2"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('services_banner_text', $settings->services_banner_text) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Organization / Impact --}}
        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Organization / Impact Section</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Eyebrow</label>
                    <input type="text" name="organization_eyebrow" value="{{ old('organization_eyebrow', $settings->organization_eyebrow) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Heading</label>
                    <input type="text" name="organization_heading" value="{{ old('organization_heading', $settings->organization_heading) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Paragraph</label>
                    <textarea name="organization_paragraph" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('organization_paragraph', $settings->organization_paragraph) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Background Image</label>
                    @if($settings->organization_image_path)
                        <img src="{{ $settings->organization_image_path }}" class="w-full max-w-xs h-32 object-cover rounded-lg border border-gray-200 mb-2">
                    @endif
                    <input type="file" name="organization_image" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm file:font-semibold hover:file:bg-emerald-100">
                    @error('organization_image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Max 4MB. Leave blank to keep the current image.</p>
                </div>
            </div>

            <div class="mt-5 pt-5 border-t border-gray-100" x-data="{
                programs: @js(array_values($programsData)),
                add() { this.programs.push({ icon: '', title: '', description: '' }) },
                remove(i) { this.programs.splice(i, 1) },
            }">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-sm font-semibold text-gray-700">Impact Program Cards</p>
                    <button type="button" @click="add()" class="text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-lg transition flex-shrink-0">
                        + Add Card
                    </button>
                </div>
                <p class="text-xs text-gray-500 mb-4">The 4 program cards (e.g. "Drug & Alcohol Rehab") over the dark background.</p>

                <div class="space-y-3">
                    <template x-for="(program, i) in programs" :key="i">
                        <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-xl">
                            <div class="grid grid-cols-3 gap-2 flex-1">
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Icon</label>
                                    <input type="text" :name="`organization_programs[${i}][icon]`" x-model="program.icon" placeholder="glass-water"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Title</label>
                                    <input type="text" :name="`organization_programs[${i}][title]`" x-model="program.title" placeholder="Drug & Alcohol Rehab"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold uppercase text-gray-500 mb-1">Description</label>
                                    <input type="text" :name="`organization_programs[${i}][description]`" x-model="program.description" placeholder="Comprehensive recovery programmes"
                                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                </div>
                            </div>
                            <button type="button" @click="remove(i)" class="mt-6 text-gray-400 hover:text-red-600">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </template>
                    <p x-show="programs.length === 0" class="text-sm text-gray-400 text-center py-4">No cards yet.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
