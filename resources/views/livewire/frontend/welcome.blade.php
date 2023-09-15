    <div>
       <div class="py-10 bg-gray-900 sm:py-14">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
              <div class="max-w-2xl mx-auto lg:max-w-none">
                <div class="text-center">
                  <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">Laraverse <sup class="relative text-sm -top-5">W-I-P</sup></h2>
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
                                class="block w-full rounded-md border-0 bg-blue-800 bg-opacity-25 py-1.5 pl-10 pr-3 text-indigo-100 placeholder:text-indigo-200 focus:bg-white focus:text-gray-900 focus:outline-none focus:ring-0 focus:placeholder:text-gray-400 sm:text-sm sm:leading-6"
                                placeholder="Search for Laravel packages, apps and tools">
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                @if(App::environment('production'))

                <dl class="mt-10 grid grid-cols-1 gap-0.5 rounded-4xl text-center sm:grid-cols-2 lg:grid-cols-3">
                  <div class="flex flex-col p-4 bg-blue-900">

                    <div>
                        <div>
                            <div class="relative z-20 mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                              <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                                <span class="flex items-center">
                                  <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                  <span class="block ml-3 truncate">Everything Laravel and PHP</span>
                                </span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                  <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                              </button>

                              <ul
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3"
                                style="display: none;"
                                @click="open = false"
                                >

                                <!--
                                  Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                                  Highlighted: "bg-indigo-600 text-white", Not Highlighted: "text-gray-900"
                                -->
                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                  <div class="flex items-center">
                                    <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                    <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                    <span class="block ml-3 font-normal truncate">Laravel apps</span>
                                  </div>

                                  <!--
                                    Checkmark, only display for selected option.

                                    Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                                  -->
                                  <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    </svg>
                                  </span>
                                </li>

                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">

                                      <span class="block ml-3 font-normal truncate">Laravel packages</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      </svg>
                                    </span>
                                </li>

                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">

                                      <span class="block ml-3 font-normal truncate">Laravel software</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      </svg>
                                    </span>
                                </li>


                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">

                                      <span class="block ml-3 font-normal truncate">Laravel and PHP packages</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      </svg>
                                    </span>
                                </li>


                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">

                                      <span class="block ml-3 font-normal truncate">Laravel courses</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      </svg>
                                    </span>
                                </li>


                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">

                                      <span class="block ml-3 font-normal truncate">Laravel books</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      </svg>
                                    </span>
                                </li>


                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">

                                      <span class="block ml-3 font-normal truncate">Laravel online resources</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      </svg>
                                    </span>
                                </li>


                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">

                                      <span class="block ml-3 font-normal truncate">Laravel SaaS solutions</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      </svg>
                                    </span>
                                </li>

                                </ul>
                            </div>
                        </div>
                      </div>


                  </div>
                  <div class="flex flex-col p-4 bg-blue-900">

                    <div>
                        <div>
                            <div class="relative z-20 mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                              <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                                <span class="flex items-center">
                                  <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                  <span class="block ml-3 truncate">Filter by Platform or TechStack</span>
                                </span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                  <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                              </button>

                              <ul
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3"
                                style="display: none;"
                                @click="open = false"
                                >

                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                  <div class="flex items-center">
                                    <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                    <span class="block ml-3 font-normal truncate">TALL-Stack - <a href="#">Info</a></span>
                                  </div>
                                  <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                    <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                    </svg>
                                  </span>
                                </li>

                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">VILT-Stack</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                </li>

                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">RILT-Stack</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Filament</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Statamic</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">October CMS</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Laravel Nova</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Flarum</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Find more ...</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Version them .../span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Spatie only</span>
                                    </div>
                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                              </ul>
                            </div>
                        </div>
                      </div>

                  </div>
                  <div class="flex flex-col p-4 bg-blue-900">

                    <div>
                        <div>
                            <div class="relative z-20 mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                              <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                                <span class="flex items-center">
                                  <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                  <span class="block ml-3 truncate">Filter by Category or Type</span>
                                </span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 ml-3 pointer-events-none">
                                  <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd" />
                                  </svg>
                                </span>
                              </button>

                              <ul
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-10 w-full py-1 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-56 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3"
                                style="display: none;"
                                @click="open = false"
                                >

                                <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Admin Panel</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">APIs</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Models</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Automation</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Deployment</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Too many tags ...</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                  <li class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9" id="listbox-option-0" role="option">
                                    <div class="flex items-center">
                                      <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                      <span class="block ml-3 font-normal truncate">Users</span>
                                    </div>

                                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                      <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                      </svg>
                                    </span>
                                  </li>

                                </ul>
                            </div>
                        </div>
                      </div>

                  </div>
                </dl>
              </div>
              <div class="text-center">
                <div class="text-white pt-7">Filter by compatibility</div>
                <div class="pt-1 text-gray-500">PHP 8 - Laravel 10 - Livewire 3 - TailwindCSS 3 - AlpineJS 3 - Filament 3</div>
              </div>

              @endif

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

                 <!--
                This example requires some changes to your config:

                ```
                // tailwind.config.js
                module.exports = {
                    // ...
                    plugins: [
                    // ...
                    require('@tailwindcss/forms'),
                    ],
                }
                ```
                -->
                <div class="mt-12">
                    <footer class="bg-gray-900" aria-labelledby="footer-heading">
                        <h2 id="footer-heading" class="sr-only">Footer</h2>
                        <div class="px-6 pt-20 pb-8 mx-auto max-w-7xl sm:pt-24 lg:px-8 lg:pt-32">
                        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                            <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                            <div class="md:grid md:grid-cols-2 md:gap-8">
                                <div>
                                <h3 class="text-sm font-semibold leading-6 text-white">Laraverse</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">About</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Advertise</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">API</a>
                                    </li>
                                </ul>
                                </div>
                                <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-semibold leading-6 text-white">Made with</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Laravel</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Livewire</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">AlpineJS</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">TailwindCSS</a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            <div class="md:grid md:grid-cols-2 md:gap-8">
                                <div>
                                <ul role="list" class="mt-12 space-y-4">
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Filament</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Spatie</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Vemto</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Forge</a>
                                    </li>
                                </ul>
                                </div>
                                <div class="mt-10 md:mt-0">
                                <h3 class="text-sm font-semibold leading-6 text-white">Legal</h3>
                                <ul role="list" class="mt-6 space-y-4">
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Contact</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Privacy</a>
                                    </li>
                                    <li>
                                    <a href="#" class="text-sm leading-6 text-gray-300 hover:text-white">Terms</a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            </div>
                            <div class="mt-10 xl:mt-0">
                            <h3 class="text-sm font-semibold leading-6 text-white">Stay informed</h3>
                            <p class="mt-2 text-sm leading-6 text-gray-300">Never miss a news about Laravel, you prefered TechStack and latest packages and tools.</p>
                            <form class="mt-6 sm:flex sm:max-w-md">
                                <label for="email-address" class="sr-only">Email address</label>
                                <input type="email" name="email-address" id="email-address" autocomplete="email" required class="w-full min-w-0 appearance-none rounded-md border-0 bg-white/5 px-3 py-1.5 text-base text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:w-64 sm:text-sm sm:leading-6 xl:w-full" placeholder="Enter your email">
                                <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                                <button type="submit" class="flex items-center justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-indigo-500 rounded-md shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Subscribe</button>
                                </div>
                            </form>
                            </div>
                        </div>
                        <div class="pt-8 mt-16 border-t border-white/10 sm:mt-20 md:flex md:items-center md:justify-between lg:mt-24">
                            <div class="flex space-x-6 md:order-2">
                            <a href="https://twitter.com/adrolli" class="text-gray-500 hover:text-gray-400">
                                <span class="sr-only">Twitter</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="https://github.com/adrolli/laraverse/" class="text-gray-500 hover:text-gray-400">
                                <span class="sr-only">GitHub</span>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            </div>
                            <p class="mt-8 text-xs leading-5 text-gray-400 md:order-1 md:mt-0">&copy; 2023 Alf Drollinger. All rights reserved.</p>
                        </div>
                        </div>
                    </footer>

                </div>
            </div>

