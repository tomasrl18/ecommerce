<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    <h1 class="text-3xl text-center font-semibold mb-8">
        Complete los datos para crear un usuario
    </h1>

    <div class="grid grid-cols-2 gap-6 mb-4">
        <div>
            <x-jet-label value="Nombre" />

            <x-jet-input type="text" wire:model="name" class="w-full"
                         placeholder="Ingrese el nombre de usuario" />

            <x-jet-input-error for="name" />
        </div>

        <div>
            <x-jet-label value="Correo electrónico" />

            <x-jet-input type="email" wire:model="email" class="w-full"
                         placeholder="Ingrese el correo electrónico" />

            <x-jet-input-error for="email" />
        </div>

        <div>
            <x-jet-label value="Contraseña" />

            <x-jet-input type="password" wire:model="password" class="w-full"
                         placeholder="Ingrese la contraseña" />

            <x-jet-input-error for="password" />
        </div>

        <div>
            <x-jet-label value="Repita la contraseña" />

            <x-jet-input type="password" wire:model="password2" class="w-full"
                         placeholder="Repita la contraseña" />

            <x-jet-input-error for="password2" />
        </div>
    </div>

    <div class="flex mt-4">
        <x-jet-button wire:loading.attr="disabled" wire:target="addUser" wire:click="addUser" class="ml-auto">
            Crear usuario
        </x-jet-button>
    </div>

</div>
