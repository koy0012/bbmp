@if(!$verified)
<div class="flex justify-center">
    <a href="#" class="block w-5/6 lg:w-1/3 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-red-500 dark:text-white text-center ">Not Verified</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400 text-center">{{$name}}</p>
    </a>
</div>

@else

<div class="flex justify-center">
    <a href="#" class="block w-5/6 lg:w-1/3 p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-green-500 text-center">Verified</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400 text-center">{{$name}}</p>
    </a>
</div>

@endif