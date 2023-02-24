<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="font-semibold text-xl text-gray-600 leading-tight">
                Lista de productos
            </h2>

            <x-button-link class="ml-auto" href="{{route('admin.products.create')}}">
                Agregar producto
            </x-button-link>
        </div>

{{--        <div class="relative px-10 cursor-pointer" style="padding-top: 25px">--}}
{{--            <h1>--}}
{{--                Columnas--}}
{{--            </h1>--}}

{{--            <div class="absolute bg-white w-2/3 p-3 rounded border shadow-md z-99"--}}
{{--                 x-show="showColumn" x-on:click.away="showColumn = false">--}}
{{--                @foreach ($columns as $column)--}}
{{--                    <x-jet-label>--}}
{{--                        <x-jet-checkbox--}}
{{--                            wire:model="activeColumns"--}}
{{--                            name="columns[]"--}}
{{--                            value="{{$column}}" />--}}
{{--                        {{$column}}--}}
{{--                    </x-jet-label>--}}
{{--                @endforeach--}}
{{--            </div>--}}

{{--            <x-jet-input-error for="" />--}}
{{--        </div>--}}

        <div class="relative px-10 cursor-pointer" style="padding-bottom: 50px">
            Columnas mostradas

            <div class="absolute bg-white w-2/3 p-3 rounded border shadow-md z-99">
                <div>
                    @foreach ($columns as $column)
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="activeColumns"
                                   value="{{ $column }}">

                            <span class="ml-1">{{ $column }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>

    <x-table-responsive>
        <div style="width: 25%;">
            <select wire:model="pagination" class="form-control w-full" style="text-align: center">
                <option value="" selected disabled>Seleccionar un valor para paginar</option>

                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <div class="px-6 py-4">
            <x-jet-input class="w-full"
                         wire:model="search"
                         type="text"
                         placeholder="Introduzca el nombre del producto a buscar" />
        </div>

        @if($products->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
{{--                    @foreach($columns as $column)--}}
{{--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">--}}
{{--                            {{ $column }}--}}
{{--                        </th>--}}
{{--                    @endforeach--}}

                    @if($this->activateColumn('Nombre'))
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                            Nombre
                        </th>
                    @endif

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                        Categoría
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                        Estado
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                        Precio
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                        Marca
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                        Stock disponible
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                        Nº de ventas
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="text-align: center">
                        Creado el
                    </th>

                    <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Editar</span>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">

                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 object-cover">
                                    <img class="h-10 w-10 rounded-full" src="{{ $product->images->count() ? Storage::url($product->images->first()->url) : 'img/default.jpg'  }}" alt="">
                                </div>

                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $product->name }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900" style="text-align: center">{{ $product->subcategory->category->name }}</div>
                            <div class="text-sm text-gray-500" style="text-align: center">{{ $product->subcategory->name }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $product->status == 1 ? 'red' : 'green'
                            }}-100 text-{{ $product->status == 1 ? 'red' : 'green' }}-800">
                                {{ $product->status == 1 ? 'Borrador' : 'Publicado' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->price }} &euro;
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" style="text-align: center">
                            {{ $product->brand->name }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" style="text-align: center">
                            {{ $product->stock }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" style="text-align: center">
                            {{ $product->sales }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" style="text-align: center">
                            {{ $product->created_at }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="px-6 py-4">
                No existen productos coincidentes
            </div>
        @endif

        @if($products->hasPages())
            <div class="px-6 py-4">
                {{ $products->links() }}
            </div>
        @endif
    </x-table-responsive>
</div>
