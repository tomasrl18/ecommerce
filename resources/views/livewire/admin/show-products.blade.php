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
    </x-slot>

    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Users</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the users in your account including their name, title, email and role.</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Add user</button>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

                        <x-table-responsive>
                            <div class="px-6 py-4">
                                <x-jet-input class="w-full"
                                             wire:model="search"
                                             type="text"
                                             placeholder="Introduzca el nombre del producto a buscar" />
                            </div>

                            @if($products->count())
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nombre</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Categoria</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estado</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Precio</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Editar</span>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 bg-white">

                                    @foreach($products as $product)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 object-cover">
                                                        <img class="h-10 w-10 rounded-full" src="{{ Storage::url($product->images->first()->url) }}" alt="">
                                                    </div>

                                                    <div class="ml-4">
                                                        <div class="font-medium text-gray-900">
                                                            {{ $product->name }}
                                                        </div>
                                                        {{--                                                        <div class="text-gray-500">lindsay.walton@example.com</div>--}}
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <div class="text-gray-900">{{ $product->subcategory->category->name }}</div>
                                                <div class="text-gray-500">{{ $product->subcategory->name }}</div>
                                            </td>

                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex rounded-full bg-{{ $product->status == 1 ? 'red' : 'green' }}-100 px-2 text-{{ $product->status == 1 ? 'red' : 'green' }} font-semibold leading-5 text-green-800">
                                                    {{ $product->status == 1 ? 'Borrador' : 'Publicado' }}
                                                </span>
                                            </td>

                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $product->price }} &euro;
                                            </td>

                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <!-- More people... -->
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
                </div>
            </div>
        </div>
    </div>
</div>
