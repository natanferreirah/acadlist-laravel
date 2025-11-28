<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white text-gray-100 hover:bg-blue-700 focus:bg-gray-700 focus:bg-blue-800 active:bg-gray-900 :active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
