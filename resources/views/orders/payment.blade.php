<x-app-layout>
    <div class="container-menu py-8">
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
            <p class="text-gray-700 uppercase"><span class="font-semibold">Número de Orden:</span> {{ $order->id }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-lg font-semibold uppercase">Envío</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
