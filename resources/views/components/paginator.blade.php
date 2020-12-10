@if($paginator->hasPages())
    <div class="flex justify-between border-t-2 border-gray-100 pt-8 mt-8">
        <div>
            @unless($paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-block hover:underline">
                    Previous Page
                </a>
            @endunless
        </div>

        <div>
            @if($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-block hover:underline">
                    Next Page
                </a>
            @endif
        </div>
    </div>
@endif
