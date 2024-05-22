@if ($show)
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
