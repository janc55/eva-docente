<x-filament-panels::page>
    <x-filament::section aside>
        <x-slot name="heading">
            Resumen
        </x-slot>
        <x-filament::section>
            <x-slot name="heading">
                Seccion 1
            </x-slot>
            <p>{{ $this->promedios['seccion1'] }}</p>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">
                Seccion 2
            </x-slot>
            <p>{{ $this->promedios['seccion2'] }}</p>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">
                Seccion 3
            </x-slot>
            <p>{{ $this->promedios['seccion3'] }}</p>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">
                Seccion 4
            </x-slot>
            <p>{{ $this->promedios['seccion4'] }}</p>
        </x-filament::section> 
    </x-filament::section>
</x-filament-panels::page>
