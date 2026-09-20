@extends('layouts.admin')

@section('title', 'Site Settings')

@section('breadcrumb')
    <x-breadcrumb :items="[
        ['label' => 'Admin', 'url' => route('admin.home')],
        ['label' => 'Settings'],
    ]" />
@endsection

@section('content')
    <x-layout.page-header
        title="Settings"
        subtitle="Manage site configuration, hero text, and contact information."
    />

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-6">
                <x-card class="shadow-sm mb-4">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-globe me-2 text-primary"></i> Site &amp; Brand
                    </h5>

                    <x-form.input
                        name="site_name"
                        label="Site Name / Author"
                        :value="$settings['site_name'] ?? ''"
                        required
                        help="Display name in navbar and copyright."
                    />

                    <x-form.input
                        name="site_title"
                        label="Browser Title (SEO)"
                        :value="$settings['site_title'] ?? ''"
                        required
                        help="Default document title for the public homepage."
                    />

                    <x-form.input
                        name="freelance_status"
                        label="Availability Status"
                        :value="$settings['freelance_status'] ?? ''"
                        help="E.g., Available for Projects, Open for Hire."
                    />
                </x-card>

                <x-card class="shadow-sm">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-person-lines-fill me-2 text-primary"></i> Contact &amp; Location
                    </h5>

                    <x-form.input
                        name="contact_email"
                        label="Contact Email"
                        type="email"
                        :value="$settings['contact_email'] ?? ''"
                        required
                    />

                    <x-form.input
                        name="contact_phone"
                        label="Phone Number"
                        :value="$settings['contact_phone'] ?? ''"
                    />

                    <x-form.input
                        name="contact_location"
                        label="Location"
                        :value="$settings['contact_location'] ?? ''"
                        help="City, Country (e.g., Mandalay, Myanmar)."
                    />
                </x-card>

                <x-card class="shadow-sm mt-4">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-search me-2 text-primary"></i> Search Engine Optimization (SEO)
                    </h5>

                    <x-form.textarea
                        name="meta_description"
                        label="Meta Description (Default)"
                        :value="$settings['meta_description'] ?? ''"
                        :rows="3"
                        help="Recommended 150-160 characters. Used in Google search result snippets."
                    />

                    <x-form.input
                        name="meta_keywords"
                        label="Meta Keywords"
                        :value="$settings['meta_keywords'] ?? ''"
                        help="Comma-separated keywords (e.g. Web Developer, Laravel, PHP, Portfolio)."
                    />

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <x-form.input
                                name="meta_author"
                                label="Meta Author"
                                :value="$settings['meta_author'] ?? ''"
                                help="E.g. Myat Min Htay"
                            />
                        </div>
                        <div class="col-sm-6">
                            <x-form.input
                                name="twitter_handle"
                                label="Twitter / X Handle"
                                :value="$settings['twitter_handle'] ?? ''"
                                help="E.g. @myatminhtay"
                            />
                        </div>
                    </div>

                    <x-form.select
                        name="robots_indexing"
                        label="Search Engine Visibility"
                        :options="[
                            '1' => 'Allow search engines to index this site (index, follow)',
                            '0' => 'Discourage search engines from indexing this site (noindex, nofollow)',
                        ]"
                        :selected="$settings['robots_indexing'] ?? '1'"
                        help="Controls robots.txt and meta robots tags."
                    />
                </x-card>
            </div>

            <div class="col-lg-6">
                <x-card class="shadow-sm mb-4">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-megaphone me-2 text-primary"></i> Hero Pitch
                    </h5>

                    <x-form.input
                        name="hero_title"
                        label="Hero Title / Role"
                        :value="$settings['hero_title'] ?? ''"
                        required
                        help="E.g., Full Stack Website Developer."
                    />

                    <x-form.textarea
                        name="hero_subtitle"
                        label="Hero Subtitle / Value Proposition"
                        :value="$settings['hero_subtitle'] ?? ''"
                        :rows="3"
                        required
                    />
                </x-card>

                <x-card class="shadow-sm mb-4">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-card-text me-2 text-primary"></i> About &amp; Bio
                    </h5>

                    <x-form.textarea
                        name="about_bio"
                        label="About Bio (Detailed)"
                        :value="$settings['about_bio'] ?? ''"
                        :rows="4"
                    />

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <x-form.input
                                name="education"
                                label="Education"
                                :value="$settings['education'] ?? ''"
                            />
                        </div>
                        <div class="col-sm-6">
                            <x-form.input
                                name="birthday"
                                label="Birthday / Year"
                                :value="$settings['birthday'] ?? ''"
                            />
                        </div>
                    </div>
                </x-card>

                <div class="d-flex justify-content-end gap-2">
                    <x-button variant="primary" type="submit" size="lg">
                        <i class="bi bi-check-lg me-1"></i> Save Settings
                    </x-button>
                </div>
            </div>
        </div>
    </form>
@endsection
