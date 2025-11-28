<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border-transparent border-gray-300 hover:bg-gray-400 rounded-md font-semibold text-xs text-gray-00 shadow-sm focus:outline-none  disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
    