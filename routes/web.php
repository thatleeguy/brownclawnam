<?php

use App\Http\Controllers\CapabilityController;
use App\Http\Controllers\CaseStudyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\PageController;
use App\Models\CaseStudy;
use App\Models\Capability;
use App\Models\Insight;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Spatie\Feed\Helpers\FeedContentType;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/capabilities', [CapabilityController::class, 'index'])->name('capabilities.index');
Route::get('/capabilities/{capability:slug}', [CapabilityController::class, 'show'])->name('capabilities.show');

Route::get('/work', [CaseStudyController::class, 'index'])->name('work.index');
Route::get('/work/{work:slug}', [CaseStudyController::class, 'show'])->name('work.show');

Route::get('/briefings', [InsightController::class, 'index'])->name('briefings.index');
Route::get('/briefings/{insight:slug}', [InsightController::class, 'show'])->name('briefings.show');

Route::get('/firm', [PageController::class, 'firm'])->name('firm');

// Serve admin-uploaded media from shared storage (persists across deploys, no symlink needed).
Route::get('/media/{path}', function (string $path) {
    abort_unless(\Illuminate\Support\Facades\Storage::disk('uploads')->exists($path), 404);

    return \Illuminate\Support\Facades\Storage::disk('uploads')
        ->response($path, null, ['Cache-Control' => 'public, max-age=604800']);
})->where('path', '.*')->name('media');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contact.store');

// SEO / feeds / sitemap
Route::feeds();

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
        ->add(Url::create(route('capabilities.index'))->setPriority(0.8))
        ->add(Url::create(route('work.index'))->setPriority(0.8))
        ->add(Url::create(route('briefings.index'))->setPriority(0.8))
        ->add(Url::create(route('firm'))->setPriority(0.7))
        ->add(Url::create(route('contact'))->setPriority(0.6));

    foreach (Capability::published()->get() as $cap) {
        $sitemap->add(Url::create(route('capabilities.show', $cap))->setPriority(0.7));
    }
    foreach (CaseStudy::published()->get() as $c) {
        $sitemap->add(Url::create(route('work.show', $c))->setPriority(0.7));
    }
    foreach (Insight::published()->get() as $i) {
        $sitemap->add(
            Url::create(route('briefings.show', $i))
                ->setLastModificationDate($i->updated_at)
                ->setPriority(0.7)
        );
    }

    return response($sitemap->render(), 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::get('/robots.txt', function () {
    return response("User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: " . url('/sitemap.xml') . "\n", 200, [
        'Content-Type' => 'text/plain',
    ]);
});
