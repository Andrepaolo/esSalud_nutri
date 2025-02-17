<div x-data="{ open: @entangle('showDietModal') }">
    <div x-show="open" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-4 rounded-lg shadow-lg w-4/5 max-w-3xl">
            <h2 class="text-lg font-semibold mb-2">Dieta <span class="text-purple-500">{{ $currentMeal }}</span></h2>

            <div class="grid grid-cols-7 gap-2 overflow-y-auto max-h-screen">
                @foreach($diets as $diet)
                    <label class="flex items-center space-x-1 bg-gray-100 p-1 rounded shadow text-[0.8rem]">
                        <input type="checkbox"
                               value="{{ $diet->id }}"
                               x-model="$wire.selectedDiets">
                        <span>{{ $diet->name }}</span>
                    </label>
                @endforeach
            </div>

            <div class="flex justify-end space-x-2 mt-2">
                <button @click="open = false" class="bg-gray-500 text-white px-2 py-1 rounded text-[0.7rem]">
                    ❌ Cancelar
                </button>
                <button wire:click="saveDietSelection" class="bg-blue-500 text-white px-2 py-1 rounded text-[0.7rem]">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>