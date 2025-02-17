<div wire:ignore>
    <x-dialog-modal wire:ignore.self wire:model="isOpen" :close-on-click-away="false">
        <x-slot name="title">
            <h3>{{ $area['id'] ? 'Editar Área' : 'Añadir Nueva Área' }}</h3>
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="mb-4">
                    <x-label value="Nombre del Área" class="font-bold" />
                    <x-input type="text" wire:model.defer="area.nombre" class="w-full" />
                    <x-input-error for="area.nombre" />
                </div>
                <div class="mb-4">
                    <x-label value="pequeña descripción" class="font-bold" />
                    <x-input type="text" wire:model.defer="area.description" class="w-full" />
                    <x-input-error for="area.description" />
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('isOpen', false)" class="mx-2">
                Cancelar
            </x-secondary-button>
            <x-button wire:click.prevent="store" wire:loading.attr="disabled" wire:target="store">
                Guardar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
