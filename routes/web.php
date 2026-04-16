<?php

use App\Http\Controllers\ProfileController;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\MemberOrganization;
use App\Models\AboutBlock;
use App\Models\Service;
use App\Models\FocusArea;
use App\Models\Notification;
use App\Models\FooterSetting;
use App\Models\SecuritySetting;
use App\Models\HeroSlide;
use App\Models\User;
use App\Models\ForumRegistration;
use App\Models\UaeResident;
use App\Models\MediaItem;
use App\Models\Program;
use App\Models\Objective;
use App\Models\GeneralSetting;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ForumRegistrationController;
use App\Http\Controllers\UaeResidentController;
use App\Http\Controllers\TanfordMemberController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\MemberOrganizationController as AdminMemberController;
use App\Http\Controllers\Admin\TeamMemberController as AdminTeamMemberController;
use App\Http\Controllers\Admin\MediaItemController as AdminMediaController;
use App\Http\Controllers\Admin\AboutBlockController as AdminAboutController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\FocusAreaController as AdminFocusAreaController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\FooterController as AdminFooterController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\Admin\ForumRegistrationController as AdminForumRegistrationController;
use App\Http\Controllers\Admin\UaeResidentController as AdminUaeResidentController;
use App\Http\Controllers\Admin\GeneralSettingController as AdminGeneralSettingController;
use App\Http\Controllers\Admin\MailSettingController as AdminMailSettingController;
use App\Http\Controllers\Admin\SeoSettingController as AdminSeoSettingController;
use App\Http\Controllers\Admin\SecuritySettingController as AdminSecuritySettingController;
use App\Http\Controllers\Admin\HeroController as AdminHeroController;
use App\Http\Controllers\Admin\TanfordMemberController as AdminTanfordMemberController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ObjectiveController as AdminObjectiveController;
use App\Http\Controllers\SuperAdminController;

// Routes protected by system on/off middleware
Route::middleware(\App\Http\Middleware\CheckSystemEnabled::class)->group(function () {

Route::get('/', function () {
    $latestPosts = Post::query()
        ->whereNotNull('published_at')
        ->latest('published_at')
        ->take(3)
        ->get();

    $testimonials = Testimonial::query()
        ->latest('id')
        ->take(6)
        ->get();

    $teamMembers = TeamMember::query()
        ->latest('id')
        ->take(8)
        ->get();

    $memberOrganizations = MemberOrganization::query()
        ->latest('id')
        ->get();

    $aboutBlock = AboutBlock::query()->first();

    $focusAreas = FocusArea::query()
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get(['id', 'title', 'description', 'icon', 'sort_order']);

    $heroSlides = HeroSlide::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get(['id', 'title', 'badge', 'description', 'sort_order', 'is_active']);

    $notifications = Notification::query()
        ->where('is_published', true)
        ->orderBy('sort_order')
        ->orderBy('id')
        ->get(['id', 'title', 'url', 'sort_order']);

    $footer = FooterSetting::query()->first();

    $securitySetting = SecuritySetting::query()->first();
    $canRegisterSetting = ! $securitySetting || $securitySetting->allow_registration;

    $programs = Program::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->take(6)
        ->get();

    $objectives = Objective::query()
        ->where('is_active', true)
        ->orderBy('number')
        ->get();

    $generalSetting = GeneralSetting::query()->first();

    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register') && $canRegisterSetting,
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'posts' => $latestPosts,
        'about' => $aboutBlock,
        'focusAreas' => $focusAreas,
        'notifications' => $notifications,
        'heroSlides' => $heroSlides,
        'footer' => $footer,
        'testimonials' => $testimonials,
        'teamMembers' => $teamMembers,
        'members' => $memberOrganizations,
        'programs' => $programs,
        'objectives' => $objectives,
        'generalSetting' => $generalSetting,
    ]);
});

Route::get('/about', function () {
    return Inertia::render('About');
});

Route::get('/contact', function () {
    return Inertia::render('Contact');
});

Route::get('/faq', function () {
    return Inertia::render('FAQ');
});

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::get('/programs', function () {
    $programs = Program::query()
        ->where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    
    return Inertia::render('Programs', [
        'programs' => $programs,
    ]);
})->name('programs.index');

Route::get('/partners', function () {
    return Inertia::render('Partners');
});

Route::get('/events', function () {
    return Inertia::render('Events');
});

Route::get('/resources', function () {
    return Inertia::render('Resources');
});

Route::get('/donate', function () {
    return Inertia::render('Donate');
})->name('donate');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/how-it-works', function () {
    return Inertia::render('HowItWorks');
});

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/uaeresidents', function () {
    return Inertia::render('UaeResidents');
})->name('uaeresidents');

Route::post('/uaeresidents', [UaeResidentController::class, 'store'])->name('uaeresidents.store');

Route::get('/uaeresidents/preview/{resident}', [UaeResidentController::class, 'preview'])
    ->name('uaeresidents.preview');

Route::get('/forumregster', [ForumRegistrationController::class, 'show'])->name('forum.register.show');

Route::post('/forumregster', [ForumRegistrationController::class, 'store'])->name('forum.register.store');

Route::get('/forumregster/preview/{registration}', [ForumRegistrationController::class, 'preview'])
    ->name('forum.register.preview');

Route::get('/tanford-membership', function () {
    return Inertia::render('TanfordMembership');
})->name('tanford-membership');

Route::post('/tanford-membership', [TanfordMemberController::class, 'store'])->name('tanford-membership.store');

Route::get('/tanford-membership/preview/{member}', [TanfordMemberController::class, 'preview'])
    ->name('tanford-membership.preview');

Route::get('/dashboard', function () {
    $userCount = User::query()->count();

    $publishedPostCount = Post::query()
        ->whereNotNull('published_at')
        ->count();

    $mediaCount = MediaItem::query()->count();

    $memberCount = MemberOrganization::query()->count();
    $teamCount = TeamMember::query()->count();

    $forumTotal = ForumRegistration::query()->count();
    $forumPending = ForumRegistration::query()
        ->whereNull('status')
        ->orWhere('status', 'pending')
        ->count();

    $uaeTotal = UaeResident::query()->count();
    $uaePending = UaeResident::query()
        ->whereNull('status')
        ->orWhere('status', 'pending')
        ->count();

    $recentForum = ForumRegistration::query()
        ->latest('created_at')
        ->take(5)
        ->get([
            'id',
            'forum_name',
            'name',
            'email',
            'status',
            'created_at',
        ]);

    $recentUae = UaeResident::query()
        ->latest('created_at')
        ->take(5)
        ->get([
            'id',
            'name',
            'email',
            'city',
            'status',
            'created_at',
        ]);

    return Inertia::render('Dashboard', [
        'dashboard' => [
            'stats' => [
                'users' => $userCount,
                'posts' => $publishedPostCount,
                'media' => $mediaCount,
                'members' => $memberCount,
                'team' => $teamCount,
                'forum' => [
                    'total' => $forumTotal,
                    'pending' => $forumPending,
                ],
                'uae' => [
                    'total' => $uaeTotal,
                    'pending' => $uaePending,
                ],
            ],
            'recentActivity' => [
                'forum' => $recentForum,
                'uae' => $recentUae,
            ],
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Admin-only routes (users, all settings)
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update-role');
        Route::post('/users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('/users/{user}/ban', [\App\Http\Controllers\Admin\UserController::class, 'ban'])->name('users.ban');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Admin general settings
        Route::get('/admin/settings/general', [AdminGeneralSettingController::class, 'index'])->name('admin.settings.general');
        Route::post('/admin/settings/general', [AdminGeneralSettingController::class, 'update'])->name('admin.settings.general.update');

        // Admin mail / SMTP settings
        Route::get('/admin/settings/mail', [AdminMailSettingController::class, 'index'])->name('admin.settings.mail');
        Route::post('/admin/settings/mail', [AdminMailSettingController::class, 'update'])->name('admin.settings.mail.update');
        Route::post('/admin/settings/mail/test', [AdminMailSettingController::class, 'sendTest'])->name('admin.settings.mail.test');

        // Admin SEO settings
        Route::get('/admin/settings/seo', [AdminSeoSettingController::class, 'index'])->name('admin.settings.seo');
        Route::post('/admin/settings/seo', [AdminSeoSettingController::class, 'update'])->name('admin.settings.seo.update');

        // Admin security settings
        Route::get('/admin/settings/security', [AdminSecuritySettingController::class, 'index'])->name('admin.settings.security');
        Route::post('/admin/settings/security', [AdminSecuritySettingController::class, 'update'])->name('admin.settings.security.update');
    });

    // Editor & Admin routes (CMS content management)
    Route::middleware('roles:admin,editor')->group(function () {
        // Admin blog management
        Route::get('/admin/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
        Route::get('/admin/posts/create', [AdminPostController::class, 'create'])->name('admin.posts.create');
        Route::get('/admin/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('admin.posts.edit');
        Route::post('/admin/posts', [AdminPostController::class, 'store'])->name('admin.posts.store');
        Route::post('/admin/posts/{post}', [AdminPostController::class, 'update'])->name('admin.posts.update');
        Route::post('/admin/posts/{post}/delete', [AdminPostController::class, 'destroy'])->name('admin.posts.destroy');

        // Admin testimonials management
        Route::get('/admin/testimonials', [AdminTestimonialController::class, 'index'])->name('admin.testimonials.index');
        Route::post('/admin/testimonials', [AdminTestimonialController::class, 'store'])->name('admin.testimonials.store');
        Route::put('/admin/testimonials/{testimonial}', [AdminTestimonialController::class, 'update'])->name('admin.testimonials.update');
        Route::delete('/admin/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');

        // Admin team members management
        Route::get('/admin/team-members', [AdminTeamMemberController::class, 'index'])->name('admin.team-members.index');
        Route::post('/admin/team-members', [AdminTeamMemberController::class, 'store'])->name('admin.team-members.store');
        Route::post('/admin/team-members/{teamMember}', [AdminTeamMemberController::class, 'update'])->name('admin.team-members.update');
        Route::delete('/admin/team-members/{teamMember}', [AdminTeamMemberController::class, 'destroy'])->name('admin.team-members.destroy');

        // Admin members management
        Route::get('/admin/members', [AdminMemberController::class, 'index'])->name('admin.members.index');
        Route::post('/admin/members', [AdminMemberController::class, 'store'])->name('admin.members.store');
        Route::put('/admin/members/{member}', [AdminMemberController::class, 'update'])->name('admin.members.update');
        Route::delete('/admin/members/{member}', [AdminMemberController::class, 'destroy'])->name('admin.members.destroy');

        // Admin media gallery management
        Route::get('/admin/media', [AdminMediaController::class, 'index'])->name('admin.media.index');
        Route::post('/admin/media', [AdminMediaController::class, 'store'])->name('admin.media.store');
        Route::post('/admin/media/{item}/delete', [AdminMediaController::class, 'destroy'])->name('admin.media.destroy');

        // Admin about section management
        Route::get('/admin/about', [AdminAboutController::class, 'index'])->name('admin.about.index');
        Route::post('/admin/about', [AdminAboutController::class, 'update'])->name('admin.about.update');

        // Admin services management
        Route::get('/admin/services', [AdminServiceController::class, 'index'])->name('admin.services.index');
        Route::post('/admin/services', [AdminServiceController::class, 'store'])->name('admin.services.store');
        Route::post('/admin/services/{service}', [AdminServiceController::class, 'update'])->name('admin.services.update');
        Route::post('/admin/services/{service}/delete', [AdminServiceController::class, 'destroy'])->name('admin.services.destroy');

        // Admin focus areas management
        Route::get('/admin/focus-areas', [AdminFocusAreaController::class, 'index'])->name('admin.focus-areas.index');
        Route::post('/admin/focus-areas', [AdminFocusAreaController::class, 'store'])->name('admin.focus-areas.store');
        Route::post('/admin/focus-areas/{focusArea}', [AdminFocusAreaController::class, 'update'])->name('admin.focus-areas.update');
        Route::post('/admin/focus-areas/{focusArea}/delete', [AdminFocusAreaController::class, 'destroy'])->name('admin.focus-areas.destroy');

        // Admin programs management
        Route::get('/admin/programs', [AdminProgramController::class, 'index'])->name('admin.programs.index');
        Route::post('/admin/programs', [AdminProgramController::class, 'store'])->name('admin.programs.store');
        Route::post('/admin/programs/{program}', [AdminProgramController::class, 'update'])->name('admin.programs.update');
        Route::post('/admin/programs/{program}/delete', [AdminProgramController::class, 'destroy'])->name('admin.programs.destroy');

        // Admin objectives management
        Route::get('/admin/objectives', [AdminObjectiveController::class, 'index'])->name('admin.objectives.index');
        Route::post('/admin/objectives', [AdminObjectiveController::class, 'store'])->name('admin.objectives.store');
        Route::post('/admin/objectives/{objective}', [AdminObjectiveController::class, 'update'])->name('admin.objectives.update');
        Route::post('/admin/objectives/{objective}/delete', [AdminObjectiveController::class, 'destroy'])->name('admin.objectives.destroy');

        // Admin hero slides management
        Route::get('/admin/hero', [AdminHeroController::class, 'index'])->name('admin.hero.index');
        Route::post('/admin/hero', [AdminHeroController::class, 'store'])->name('admin.hero.store');
        Route::post('/admin/hero/{slide}', [AdminHeroController::class, 'update'])->name('admin.hero.update');
        Route::post('/admin/hero/{slide}/delete', [AdminHeroController::class, 'destroy'])->name('admin.hero.destroy');

        // Admin hero notifications management
        Route::get('/admin/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::post('/admin/notifications', [AdminNotificationController::class, 'store'])->name('admin.notifications.store');
        Route::post('/admin/notifications/{notification}', [AdminNotificationController::class, 'update'])->name('admin.notifications.update');
        Route::post('/admin/notifications/{notification}/delete', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');

        // Admin footer management
        Route::get('/admin/footer', [AdminFooterController::class, 'index'])->name('admin.footer.index');
        Route::post('/admin/footer', [AdminFooterController::class, 'update'])->name('admin.footer.update');

        // Admin newsletter subscriptions
        Route::get('/admin/newsletter', [AdminNewsletterController::class, 'index'])->name('admin.newsletter.index');
    });

    // Moderator & Admin routes (Forum & User registrations moderation)
    Route::middleware('roles:admin,moderator')->group(function () {
        // Admin forum registrations
        Route::get('/admin/forum-registrations', [AdminForumRegistrationController::class, 'index'])->name('admin.forum-registrations.index');
        Route::get('/admin/forum-registrations/{registration}', [AdminForumRegistrationController::class, 'show'])->name('admin.forum-registrations.show');
        Route::post('/admin/forum-registrations/{registration}/status', [AdminForumRegistrationController::class, 'updateStatus'])->name('admin.forum-registrations.update-status');
        Route::get('/admin/forum-registrations/export', [AdminForumRegistrationController::class, 'export'])->name('admin.forum-registrations.export');

        // Admin UAE residents
        Route::get('/admin/uae-residents', [AdminUaeResidentController::class, 'index'])->name('admin.uae-residents.index');
        Route::post('/admin/uae-residents/{resident}/status', [AdminUaeResidentController::class, 'updateStatus'])->name('admin.uae-residents.update-status');
        Route::get('/admin/uae-residents/export', [AdminUaeResidentController::class, 'export'])->name('admin.uae-residents.export');

        // Admin TANFORD members
        Route::get('/admin/tanford-members', [AdminTanfordMemberController::class, 'index'])->name('admin.tanford-members.index');
        Route::get('/admin/tanford-members/{member}', [AdminTanfordMemberController::class, 'show'])->name('admin.tanford-members.show');
        Route::post('/admin/tanford-members/{member}/status', [AdminTanfordMemberController::class, 'updateStatus'])->name('admin.tanford-members.update-status');
    });

    // Admin-only header notifications
    Route::middleware('role:admin')->group(function () {
        Route::post('/admin/header-notifications/read-all', function (Request $request) {
            $user = $request->user();
            if ($user && $user->role === 'admin') {
                $user->forceFill(['admin_last_seen_notifications_at' => now()])->save();
            }
            return back();
        })->name('admin.header-notifications.read-all');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

}); // end CheckSystemEnabled group

// System off page (shown when system is disabled)
Route::get('/system-off', function () {
    return Inertia::render('SystemOff');
})->name('system.off');

// Superadmin panel routes (bypass normal auth, rely on hard-coded credentials)
Route::get('/superadmin', [SuperAdminController::class, 'panel'])->name('superadmin.panel');
Route::post('/superadmin/system-toggle', [SuperAdminController::class, 'toggleSystem'])->name('superadmin.system.toggle');

require __DIR__.'/auth.php';
