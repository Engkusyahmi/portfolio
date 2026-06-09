<?php namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PermitListedURIs;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things a little nicer and
     * simpler.
     *
     * @var array<string, class-string>
     */
    public array $aliases = [
        // Default CI4 filters
        'csrf'              => CSRF::class,
        'toolbar'           => DebugToolbar::class,
        'honeypot'          => Honeypot::class,
        'invalidchars'      => InvalidChars::class,
        'permitlisteduris'  => PermitListedURIs::class,
        'secureheaders'     => SecureHeaders::class,

        // ✅ Custom auth filters
        'StudentAuthFilter' => \App\Filters\StudentAuthFilter::class,
        'DriverAuthFilter'  => \App\Filters\DriverAuthFilter::class,
        'AdminAuthFilter'   => \App\Filters\AdminAuthFilter::class,
        'auth' => \App\Filters\AuthFilter::class,

        // Optional: your other filters
        'SessionAdminFilter' => \App\Filters\SessionAdminFilter::class,
        'sessionAdmin'       => \App\Filters\SessionAdminFilter::class,
    ];

    /**
     * List of filter aliases that are always applied before and after every request.
     */
    public array $globals = [
        'before' => [
            // You can enable these if needed:
            // 'csrf',
            // 'honeypot',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Filters applied based on HTTP method.
     */
    public array $methods = [];

    /**
     * Filters applied to specific URI patterns.
     */
    public array $filters = [
        // 🔒 Student routes
        'StudentAuthFilter' => [
            'before' => [
                'student/*',
                'student-dashboard',
                'student-profile/*',
            ],
        ],

        // 🔒 Driver routes
        'DriverAuthFilter' => [
            'before' => [
                'driver/*',
                'driver-dashboard',
            ],
        ],

        // 🔒 Admin routes
        'AdminAuthFilter' => [
            'before' => [
                'admin/*',
                'admin-dashboard',
            ],
        ],
    ];
}
