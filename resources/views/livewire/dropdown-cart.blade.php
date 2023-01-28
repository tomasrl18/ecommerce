<div>
    <x-jet-dropdown width="96">

        <x-slot name="trigger">
            <span class="relative inline-block cursor-pointer">
                <x-cart size="30" color="white"></x-cart>
{{--                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">99</span>--}}
                <span class="absolute top-0 right-0 inline-block w-2 h-2 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"></span>
            </span>
        </x-slot>

        <x-slot name="content">
            <ul>
                @forelse(Cart::content() as $item)
                    <li class="flex">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
                            <p class="">Cant: {{ $item->qty }}</p>
                            <p>{{ $item->price }} &euro;</p>
                        </article>
                    </li>
                    @empty
                @endforelse
            </ul>
        </x-slot>

    </x-jet-dropdown>
</div>
