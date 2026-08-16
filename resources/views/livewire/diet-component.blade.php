<div class="py-0">
    <div>
        <div class="bg-white shadow-xl sm:rounded-lg px-6 py-4">

            <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-3">
                <input type="text" wire:model.live="search" placeholder="Buscar dietas..."
                       class="px-3 py-1 border rounded-lg shadow w-full sm:w-1/2 focus:ring-2 focus:ring-blue-400 outline-none text-sm">

                {{-- BOTÓN DE ORDENACIÓN (NUEVO) --}}
                <button wire:click="sortBy"
                        class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out w-full sm:w-auto text-sm">
                    Orden {{ $sortDirection === 'asc' ? 'A-Z ↓' : 'Z-A ↑' }}
                </button>
                {{--------------------}}

                <button wire:click="create"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out w-full sm:w-auto">
                    ➕ Nueva Dieta
                </button>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-lg">
                    <thead class="bg-gray-800 text-white">
                        <tr class="text-left text-xs font-semibold uppercase">
                            <th class="px-4 text-xs py-2">Dieta</th>
                            <th class="px-4 text-xs py-2 text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($diets as $diet)
                            <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
                                <td class="px-4 py-2 text-xs">{{ $diet->name}}</td>
                                <td class="px-4 py-2 text-xs flex justify-center space-x-2">
                                    <button wire:click="edit({{ $diet->id }})" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                                        Editar
                                    </button>
                                    <button wire:click="delete({{ $diet->id }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500">No se encontraron dietas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($diets->hasPages())
                <div class="py-3 px-2">
                    {{ $diets->links('vendor.pagination.tailwind-numbers-v2.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    @if($isOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">{{ $diet['id'] ? 'Editar Dieta' : 'Crear Nueva Dieta' }}</h2>
                    <button wire:click="closeDietFormModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                </div>
                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label for="dietName" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Dieta:</label>
                        <input type="text" id="dietName" wire:model.defer="diet.name"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('diet.name') <span class="text-red-500 text-xs italic">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="closeDietFormModal"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
