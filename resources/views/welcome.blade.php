<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laraverse</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @livewireStyles

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="antialiased">

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

                           <input id="search" name="search" class="block w-full rounded-md border-0 bg-indigo-400 bg-opacity-25 py-1.5 pl-10 pr-3 text-indigo-100 placeholder:text-indigo-200 focus:bg-white focus:text-gray-900 focus:outline-none focus:ring-0 focus:placeholder:text-gray-400 sm:text-sm sm:leading-6" placeholder="Search projects" type="search">

                        </div>
                      </div>
                    </div>
                  </div>
                <dl class="mt-16 grid grid-cols-1 gap-0.5 rounded-4xl text-center sm:grid-cols-2 lg:grid-cols-4">
                  <div class="flex flex-col p-8 bg-white/5">
                    <div>
                        <div class="relative mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                          <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                            <span class="flex items-center">
                              <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                              <span class="block ml-3 truncate">Tom Cook</span>
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
                                <img src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                <span class="block ml-3 font-normal truncate">Wade Cooper</span>
                              </div>

                              <!--
                                Checkmark, only display for selected option.

                                Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                              -->
                              <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                              </span>
                            </li>

                            <!-- More items... -->
                          </ul>
                        </div>
                    </div>
                  </div>
                  <div class="flex flex-col p-8 bg-white/5">
                    <div>
                        <div class="relative mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                          <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white    py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                            <span class="flex items-center">
                              <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                              <span class="block ml-3 truncate">Tom Cook</span>
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
                                <img src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                <span class="block ml-3 font-normal truncate">Wade Cooper</span>
                              </div>

                              <!--
                                Checkmark, only display for selected option.

                                Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                              -->
                              <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                              </span>
                            </li>

                            <!-- More items... -->
                          </ul>
                        </div>
                    </div>
                  </div>
                  <div class="flex flex-col p-8 bg-white/5">
                    <div>
                        <div class="relative mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                          <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                            <span class="flex items-center">
                              <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                              <span class="block ml-3 truncate">Tom Cook</span>
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
                                <img src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                <span class="block ml-3 font-normal truncate">Wade Cooper</span>
                              </div>

                              <!--
                                Checkmark, only display for selected option.

                                Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                              -->
                              <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                              </span>
                            </li>

                            <!-- More items... -->
                          </ul>
                        </div>
                    </div>                  </div>
                  <div class="flex flex-col p-8 bg-white/5">
                    <div>
                        <div class="relative mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                          <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
                            <span class="flex items-center">
                              <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                              <span class="block ml-3 truncate">Tom Cook</span>
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
                                <img src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
                                <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                                <span class="block ml-3 font-normal truncate">Wade Cooper</span>
                              </div>

                              <!--
                                Checkmark, only display for selected option.

                                Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                              -->
                              <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                  <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                              </span>
                            </li>

                            <!-- More items... -->
                          </ul>
                        </div>
                    </div>
                  </div>
                </dl>
              </div>
            </div>
          </div>


          <div class="bg-white">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
              <div class="grid max-w-2xl grid-cols-1 pt-5 mx-auto mt-5 gap-x-8 gap-y-16 sm:mt-8 sm:pt-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                <article class="flex flex-col items-start justify-between max-w-xl">
                    <div class="flex items-center text-xs gap-x-4">
                      <time datetime="2020-03-16" class="text-gray-500">Mar 16, 2020</time>
                      <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Marketing</a>
                    </div>
                    <div class="relative group">
                      <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                        <a href="#">
                          <span class="absolute inset-0"></span>
                          Boost your conversion rate
                        </a>
                      </h3>
                      <p class="mt-5 text-sm leading-6 text-gray-600 line-clamp-3">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
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
                  <article class="flex flex-col items-start justify-between max-w-xl">
                    <div class="flex items-center text-xs gap-x-4">
                      <time datetime="2020-03-16" class="text-gray-500">Mar 16, 2020</time>
                      <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Marketing</a>
                    </div>
                    <div class="relative group">
                      <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                        <a href="#">
                          <span class="absolute inset-0"></span>
                          Boost your conversion rate
                        </a>
                      </h3>
                      <p class="mt-5 text-sm leading-6 text-gray-600 line-clamp-3">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
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
                  <article class="flex flex-col items-start justify-between max-w-xl">
                    <div class="flex items-center text-xs gap-x-4">
                      <time datetime="2020-03-16" class="text-gray-500">Mar 16, 2020</time>
                      <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Marketing</a>
                    </div>
                    <div class="relative group">
                      <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                        <a href="#">
                          <span class="absolute inset-0"></span>
                          Boost your conversion rate
                        </a>
                      </h3>
                      <p class="mt-5 text-sm leading-6 text-gray-600 line-clamp-3">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
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

                <!-- More posts... -->
              </div>
            </div>
          </div>



    @livewireScripts

    </body>
</html>
