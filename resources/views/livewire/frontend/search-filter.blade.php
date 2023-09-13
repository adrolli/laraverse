<div>
    <div>
        <div class="relative mt-2" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
          <button  @click="open = ! open" type="button" class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
            <span class="flex items-center">
              <img src="https://styles.redditmedia.com/t5_2uakt/styles/communityIcon_fmttas2xiy351.png" alt="" class="flex-shrink-0 w-5 h-5 rounded-full">
              <span class="block ml-3 truncate">Filter</span>
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
                <span class="block ml-3 font-normal truncate">Values</span>
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
