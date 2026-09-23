<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="generate">
            <div class="grid gap-4 sm:grid-cols-[1fr_auto]">
                <x-filament::input.wrapper>
                    <x-filament::input
                        type="email"
                        wire:model="dataSubject"
                        :placeholder="__('filament-gdpr::gdpr.dsar.email')"
                        required
                    />
                </x-filament::input.wrapper>

                <x-filament::button type="submit">
                    {{ __('filament-gdpr::gdpr.dsar.submit') }}
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    <x-filament::section>
        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>