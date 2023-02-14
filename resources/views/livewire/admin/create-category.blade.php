<div>
    <x-jet-form-section submit="save" class="mb-6">>
        <x-slot name="title">
            Crear nueva categoría
        </x-slot>

        <x-slot name="description">
            Complete la información necesaria para poder crear una nueva categoría
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Nombre
                </x-jet-label>

                <x-jet-input wire:model="createForm.name" type="text" class="w-full mt-1" />

                <x-jet-input-error for="createForm.name" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Slug
                </x-jet-label>

                <x-jet-input disabled wire:model="createForm.slug" type="text" class="w-full mt-1 bg-gray-100" />
                <x-jet-input-error for="createForm.slug" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Icono
                </x-jet-label>

                <x-jet-input wire:model.defer="createForm.icon" type="text" class="w-full mt-1" />
                <x-jet-input-error for="createForm.icon" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Marcas
                </x-jet-label>

                <div class="grid grid-cols-4">
                    @foreach ($brands as $brand)
                        <x-jet-label>
                            <x-jet-checkbox
                                wire:model.defer="createForm.brands"
                                name="brands[]"
                                value="{{$brand->id}}" />
                            {{$brand->name}}
                        </x-jet-label>
                    @endforeach
                </div>
                <x-jet-input-error for="createForm.brands" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label>
                    Imagen
                </x-jet-label>

                <input wire:model="createForm.image" accept="image/*" type="file" class="mt-1" name="" id="{{ $image }}">
                <x-jet-input-error for="createForm.image" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                Categoría creada
            </x-jet-action-message>

            <x-jet-button>
                Agregar
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <x-jet-action-section>
        <x-slot name="title">
            Lista de categorías
        </x-slot>

        <x-slot name="description">
            Aquí encontrará todas las categorías agregadas
        </x-slot>

        <x-slot name="content">
            <table class="text-gray-600">
                <thead class="border-b border-gray-300">
                <tr class="text-left">
                    <th class="py-2 w-full">Nombre</th>
                    <th class="py-2">Acción</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-300">
                @foreach ($categories as $category)
                    <tr>
                        <td class="py-2">
                            <span class="inline-block w-8 text-center mr-2">
                                {!!$category->icon!!}
                            </span>

                            <span class="uppercase">
                                {{$category->name}}
                            </span>
                        </td>
                        <td class="py-2">
                            <div class="flex divide-x divide-gray-300 font-semibold">
                                <a class="pr-2 hover:text-blue-600 cursor-pointer">Editar</a>
                                <a class="pl-2 hover:text-red-600 cursor-pointer"
                                   wire:click="$emit('deleteCategory', '{{ $category->slug }}')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </x-slot>
    </x-jet-action-section>
</div>
