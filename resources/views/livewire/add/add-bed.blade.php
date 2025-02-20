<x-dialog-modal wire:model="isOpen">
    <x-slot name="title">
        <h3>{{ isset($bed['id']) ? 'Editar Cama' : 'Añadir Nueva Cama' }}</h3>
    </x-slot>

    <x-slot name="content">
        <form>
            <div class="mb-4">
                <x-label for="codigo" value="Código de Cama" />
                <x-input id="codigo" type="text" class="mt-1 block w-full" wire:model.defer="bed.codigo" autofocus />
                <x-input-error for="bed.codigo" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-label for="area_id" value="Área" />
                <select id="area_id" wire:model.defer="bed.area_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="">Selecciona un Área</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error for="bed.area_id" class="mt-2" />
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('isOpen', false)">
            Cancelar
        </x-secondary-button>

        <x-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
            Guardar
        </x-button>
    </x-slot>
</x-dialog-modal>