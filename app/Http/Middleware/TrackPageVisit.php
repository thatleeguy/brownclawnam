<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageVisit
{
    /** Path prefixes we never track. */
    protected array $skipPrefixes = [
        '/admin',
        '/livewire',
        '/storage',
        '/build',
        '/_ignition',
        '/_debugbar',
        '/filament',
        '/up',
    ];

    /** Exact paths we never track. */
    protected array $skipExact = [
        '/sitemap.xml',
        '/robots.txt',
        '/briefings.atom',
        '/favicon.ico',
    ];

    /** UA fragments that mark the visit as a bot. */
    protected array $botMarkers = [
        'bot', 'crawl', 'spider', 'baidu', 'bing', 'google', 'yahoo', 'yandex',
        'duckduckgo', 'slurp', 'facebookexternalhit', 'pingdom', 'uptimerobot',
        'gptbot', 'chatgpt', 'claude', 'perplexity', 'anthropic', 'applebot',
        'semrush', 'ahrefs', 'mj12', 'dotbot', 'twitterbot', 'linkedinbot',
        'embedly', 'curl', 'wget', 'python', 'java/', 'okhttp', 'httpclient',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            $this->record($request, $response);
        } catch (\Throwable $e) {
            // Never let analytics break a request.
            report($e);
        }

        return $response;
    }

    protected function record(Request $request, Response $response): void
    {
        if (! $request->isMethod('GET')) {
            return;
        }

        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 400) {
            return;
        }

        $path = '/' . ltrim($request->path(), '/');
        if ($path === '//') {
            $path = '/';
        }

        foreach ($this->skipPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return;
            }
        }
        if (in_array($path, $this->skipExact, true)) {
            return;
        }

        $route = $request->route();
        $name  = $route?->getName();
        if ($name && (str_starts_with($name, 'filament.') || str_starts_with($name, 'livewire.'))) {
            return;
        }

        $ua = (string) $request->userAgent();
        $isBot = $this->isBot($ua);

        PageVisit::create([
            'path'       => mb_substr($path, 0, 512),
            'route_name' => $name ? mb_substr($name, 0, 120) : null,
            'referer'    => mb_substr((string) $request->headers->get('referer'), 0, 1024) ?: null,
            'user_agent' => mb_substr($ua, 0, 512) ?: null,
            'ip_hash'    => hash('sha256', $request->ip() . config('app.key')),
            'is_bot'     => $isBot,
            'created_at' => now(),
        ]);
    }

    protected function isBot(string $ua): bool
    {
        if ($ua === '') {
            return true;
        }

        $lower = mb_strtolower($ua);
        foreach ($this->botMarkers as $needle) {
            if (str_contains($lower, $needle)) {
                return true;
            }
        }

        return false;
    }
}
