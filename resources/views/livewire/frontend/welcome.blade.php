       <div>
       <div class="py-10 bg-gray-900 sm:py-14">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
              <div class="max-w-2xl mx-auto lg:max-w-none">
                <div class="text-center">
                  <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Laraverse</h2>
                  <div class="flex justify-center flex-1 px-20 pt-10 sm:px-40 lg:justify-end">
                    <div class="w-full px-2 lg:px-6">
                      <label for="search" class="sr-only">Search projects</label>
                      <div class="relative text-indigo-200 focus-within:text-gray-400">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                          <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                          </svg>
                        </div>

                        <div>
                            <input
                                wire:model.live.debounce.500ms="search"
                                id="search" name="search" type="search"
                                class="block w-full rounded-md border-0 bg-indigo-400 bg-opacity-25 py-1.5 pl-10 pr-3 text-indigo-100 placeholder:text-indigo-200 focus:bg-white focus:text-gray-900 focus:outline-none focus:ring-0 focus:placeholder:text-gray-400 sm:text-sm sm:leading-6"
                                placeholder="Search for Laravel packages, apps and tools">
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
                <dl class="mt-16 grid grid-cols-1 gap-0.5 rounded-4xl text-center sm:grid-cols-2 lg:grid-cols-3">
                  <div class="flex flex-col p-8 bg-white/5">

                    <livewire:frontend.search-filter />

                  </div>
                  <div class="flex flex-col p-8 bg-white/5">

                    <livewire:frontend.search-filter />

                  </div>
                  <div class="flex flex-col p-8 bg-white/5">

                    <livewire:frontend.search-filter />

                  </div>
                </dl>
              </div>
            </div>
          </div>


          <div class="bg-white">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
                <div class="grid max-w-2xl grid-cols-1 pt-5 mx-auto mt-5 gap-x-8 gap-y-16 sm:mt-8 sm:pt-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">

                    @foreach ($items as $item)

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
                          <img src="{{ $item['data']['maintainers'][0]['avatar_url'] }}" alt="" class="w-10 h-10 rounded-full bg-gray-50">
                          <div class="text-sm leading-6">
                            <p class="font-semibold text-gray-900">
                              <a href="#">
                                <span class="absolute inset-0"></span>
                                {{ $item['data']['maintainers'][0]['name'] }}
                              </a>
                            </p>
                            <p class="text-gray-600">Maintainer</p>
                          </div>
                        </div>
                      </article>

                    @endforeach

                </div>


            </div>
          </div>
        </div>
