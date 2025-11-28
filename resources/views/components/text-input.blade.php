@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 border-gray-200 bg-gray-50 text-gray-900 focus:border-blue-700 focus:ring-blue-500  rounded-md shadow-sm']) }}>
