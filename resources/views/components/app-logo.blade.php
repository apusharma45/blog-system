<div class="flex aspect-square size-8 items-center justify-center rounded-md bg-zinc-900 dark:bg-white">
    <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
</div>
<div class="ms-1 grid flex-1 text-start text-sm">
    <span class="mb-0.5 truncate leading-tight font-semibold text-zinc-900 dark:text-white">{{ optional(\App\Models\Setting::where('key','site.name')->first())->value['value'] ?? config('app.name') }}</span>
</div>
