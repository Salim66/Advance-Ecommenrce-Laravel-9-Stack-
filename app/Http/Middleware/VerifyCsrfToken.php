<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        "/admin/check-current-pwd",
        "/admin/update-section-status",
        "/admin/update-categories-status",
        "/admin/append-category-level",
        "/admin/update-products-status",
        "/admin/update-attributes-status",
        "/admin/update-images-status",
        "/admin/update-brand-status",
        "/admin/update-banner-status",
        "/admin/update-coupon-status",
        "/admin/update-shipping-status",
        "/admin/update-user-status",
        "/admin/update-cms-page-status",
        "/admin/update-admins-subadmins-status",
        "/admin/update-currency-status",
        "/admin/update-rating-status",
        "/admin/update-subscriber-status",
    ];
}
