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
                <div class="ml-8">
                    <p>{{ $intro }}</p>
                </div>
            @endif
        </div>

        <div class="px-4.5 py-4">
            @include('statamic-sticky-notes::widgets._content', ['content' => $content])
        </div>
    </ui-card>

    <div id="statamic-sticky-notes-widget" class="card p-0 overflow-hidden h-full">
        <div class="border-b dark:border-dark-900">
            <div class="flex justify-between items-center p-4">
                <h2 class="flex">
                    <div class="h-6 w-6 mr-3 text-gray-800 dark:text-dark-175">
                        {!! $icon !!}
                    </div>
                    <div class="-mt-px">
                        <div>{{ $heading }}</div>

                        @if ($intro)
                            <div class="content">
                                <p>{{ $intro }}</p>
                            </div>
                        @endif
                    </div>
                </h2>
            </div>
        </div>

        <div>
            <div class="p-4">
                @include('statamic-sticky-notes::widgets._content', ['content' => $content])
            </div>
        </div>

    </div>
@endif
