@props(['name', 'options', 'selected' => '', 'placeholder' => 'Pilih...', 'id' => null, 'onchange' => null])

<div x-data="{ open: false, selected: '{{ old($name, $selected) }}', options: {{ json_encode($options) }} }" class="relative z-[99] w-full" style="isolation: isolate;">
    <button type="button" @click="open = !open" @click.away="open = false" class="input-field w-full bg-white flex justify-between items-center text-left" :class="{'ring-2 ring-blue-500 border-blue-500': open}">
        <span x-text="options[selected] || '{{ $placeholder }}'" class="truncate"></span>
        <svg class="w-4 h-4 ml-2 text-gray-500 flex-shrink-0 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
    </button>
    <div x-show="open" class="absolute mt-1 w-full bg-white border border-gray-200 rounded-md shadow-xl z-[9999] py-1 max-h-60 overflow-y-auto" style="display: none;" x-transition>
        <template x-for="(label, value) in options" :key="value">
            <button type="button" @click="selected = value; open = false; $refs.hiddenInput.value = value; $refs.hiddenInput.dispatchEvent(new Event('change', { bubbles: true })); {{ $onchange ? $onchange : '' }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors" :class="{ 'bg-blue-50 font-bold': selected === value }">
                <span x-text="label"></span>
            </button>
        </template>
    </div>
    <input type="hidden" id="{{ $id ?? $name }}" x-ref="hiddenInput" name="{{ $name }}" :value="selected">
</div>
