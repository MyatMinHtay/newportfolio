<?php

/**
 * Portfolio CMS — central project configuration.
 * Business logic does not belong here. Values only.
 *
 * @see knowledge/06-decisions.md ADR-017
 */

return [

    'site_name' => env('PROJECT_SITE_NAME', 'Myat Min Htay'),

    'author' => env('PROJECT_AUTHOR', ''),

    /*
    | Intended site timezone (keep APP_TIMEZONE in sync in .env).
    */
    'timezone' => env('PROJECT_TIMEZONE', 'Asia/Yangon'),

    /*
    | Application/docs release label (also track in knowledge/08-changelog.md).
    */
    'version' => env('PROJECT_VERSION', '0.11.0'),

    /*
    | Toastify default duration in milliseconds (ADR-016 / knowledge/27-toast-guidelines.md).
    | Wiring to JS happens in a later phase.
    */
    'toast_default_duration' => (int) env('PROJECT_TOAST_DURATION', 3000),

    /*
    | Default per-page size for admin/public indexes.
    */
    'pagination_size' => (int) env('PROJECT_PAGINATION_SIZE', 15),

    /*
    | Upload size caps in kilobytes (enforced later via Form Requests).
    | See knowledge/24-file-storage.md and knowledge/25-validation.md.
    */
    'upload_limits' => [
        'image_max_kb' => (int) env('PROJECT_UPLOAD_IMAGE_MAX_KB', 2048),
        'pdf_max_kb' => (int) env('PROJECT_UPLOAD_PDF_MAX_KB', 5120),
        'allowed_image_mimes' => ['jpg', 'jpeg', 'png', 'webp'],
        'allowed_resume_mimes' => ['pdf'],
    ],

];
