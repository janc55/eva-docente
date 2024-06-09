<x-filament-panels::page>
    {{$this->datos}}
    <x-filament::section>
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
        <div>
            <h3>Promedios por Sección</h3>
            <p>Sección 1: {{ $this->promedios['seccion1'] }}</p>
            <p>Sección 2: {{ $this->promedios['seccion2'] }}</p>
            <p>Sección 3: {{ $this->promedios['seccion3'] }}</p>
            <p>Sección 4: {{ $this->promedios['seccion4'] }}</p>
        </div>  
    </x-filament::section>
</x-filament-panels::page>
