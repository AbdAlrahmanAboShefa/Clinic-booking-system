@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-2 border-black focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm block w-full px-4 py-2.5 text-gray-900 placeholder-gray-400 transition-colors duration-200']) }}>
