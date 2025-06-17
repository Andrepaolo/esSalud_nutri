{{-- En tu archivo blade del modal de dietas --}}

<div x-data="{ open: @entangle('showDietModal') }">
    <div x-show="open" @keydown.escape.window="open = false" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg w-4/5 max-w-3xl">
            <h2 class="text-lg font-semibold mb-2">
                Seleccionar Dietas para: <span class="text-purple-500">{{ ucfirst($currentMeal) }}</span>
            </h2>

            {{-- Sección de Botones de Presets --}}
            @if (!empty($dietPresets))
                <div class="mb-3 p-3 border rounded-md bg-green-300 shadow-sm">
                    <h4 class="text-sm font-semibold mb-2 text-gray-700">Selecciones Rápidas:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($dietPresets as $index => $preset)
                            <button wire:click="applyDietPreset({{ $index }})"
                                    title="Seleccionar: {{ implode(', ', \App\Models\Diet::whereIn('id', $preset['diet_ids'])->pluck('name')->toArray()) }}"
                                    class="bg-blue-500 hover:bg-teal-600 text-white px-3 py-1 rounded-md text-xs shadow hover:shadow-md transition-all duration-150 ease-in-out">
                                {{ $preset['name'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- Fin Sección de Botones de Presets --}}

            <div class="grid grid-cols-7 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-7 gap-2 overflow-y-auto max-h-[50vh] p-2 border rounded">
                @forelse($diets as $diet)
                    <label class="flex items-center space-x-1 bg-gray-100 p-2 rounded shadow hover:bg-gray-200 cursor-pointer text-[0.8rem]">
                        <input type="checkbox"
                               value="{{ $diet->id }}"
                               wire:model="selectedDiets">
                        <span>{{ $diet->name }}</span>
                    </label>
                @empty
                    <p class="col-span-full text-center text-gray-500">No hay dietas disponibles.</p>
                @endforelse
            </div>

            <div class="mt-3">
                <label class="flex items-center space-x-2 text-sm">
                    <input type="checkbox" wire:model="applyToOtherMeals" class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
                    <span>Aplicar a otros horarios (Desayuno, 10 AM, Almuerzo, 4 PM, Cena)</span>
                </label>
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button @click="open = false; $wire.set('selectedDiets', [])"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-[0.8rem] transition-colors">
                    ❌ Cancelar
                </button>
                <button wire:click="saveDietSelection"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-[0.8rem] transition-colors">
                    💾 Guardar Selección
                </button>
            </div>
        </div>
    </div>
</div>