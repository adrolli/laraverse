<article class="flex flex-col items-start justify-between max-w-xl">
    <div class="flex items-center text-xs gap-x-4">
      <time datetime="2020-03-16" class="text-gray-500">Mar 16, 2020</time>
      <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">{{ $item['data']['type'] }}</a>
      Stars: {{ $item['data']['github_stars'] }}


    </div>
    <div class="relative group">
      <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
        <a href="https://packagist.org/packages/{{ $item->slug }}">
          <span class="absolute inset-0"></span>
          {{ $item->title }}<br>
          <small>{{ $item->slug }}</small>

        </a>
      </h3>
      <p class="mt-5 text-sm leading-6 text-gray-600 line-clamp-3">{{ $item['data']['description'] }}</p>
    </div>
    <div class="relative flex items-center mt-8 gap-x-4">
      <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="w-10 h-10 rounded-full bg-gray-50">
      <div class="text-sm leading-6">
        <p class="font-semibold text-gray-900">
          <a href="#">
            <span class="absolute inset-0"></span>
            Michael Foster
          </a>
        </p>
        <p class="text-gray-600">Co-Founder / CTO</p>
      </div>
    </div>
  </article>
