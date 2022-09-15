<!-- Desktop sidebar -->
<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 flex justify-start items-center"
            href="{{ route('dashboard') }}">
           Nexum Docs
        </a>
        <ul class="mt-6">
            <li
                class="relative px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-blue-50' : '' }}">
                <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"></span>
                <a class="inline-flex items-center w-full text-sm {{ request()->routeIs('dashboard') ? 'font-bold text-gray-800' : 'font-semibold' }} transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                    href="{{ route('dashboard') }}">
                    <x-icon.home></x-icon.home>
                    <span class="ml-4">{{ __('Dashboard') }}</span>
                </a>
            </li>
        </ul>
        <ul>
           <!-- Other menu links here... -->
        </ul>
    </div>
</aside>