@if ($show)
    <ui-card inset class="@container/widget">
        <div class="min-h-[49px] border-b border-gray-200 px-4.5 py-2 dark:border-gray-700">
            <header class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="size-5 text-gray-500">{!! $icon !!}</div>
                    <div>{{ $heading }}</div>
                </div>
            </header>
            @if ($intro)
                <div class="ml-8 text-xs text-gray-500">
                    <p>{{ $intro }}</p>
                </div>
            @endif
        </div>

        <div class="px-4.5 py-4">
            @include('statamic-sticky-notes::widgets._content', ['content' => $content])
        </div>
    </ui-card>
@endif
