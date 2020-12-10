<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 space-y-2 sm:px-6 lg:px-8">
            @foreach ($links->load('redirects') as $link)
                <div class="flex justify-between items-center bg-white rounded-lg shadow p-4">
                    <h3 class="font-montserrat font-thin text-lg">
                        {{ $link->title ?? $link->slug }}
                    </h3>

                    <div class="flex items-center space-x-4">
                        <div class="font-hairline text-gray-400">
                            <a href="{{ $link->shortLink() }}" class="hover:underline">
                                {{ $link->shortLink() }}
                            </a>
                        </div>

                        <div class="font-mono text-xl text-right w-10">
                            {{ $link->redirects->count() }}
                        </div>
                    </div>
                </div>
            @endforeach

            <x-paginator :paginator="$links" />
        </div>
    </div>
</x-app-layout>
