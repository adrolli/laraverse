    <div id="root">

        <div id="header">
            <div id="logo">Laraverse</div>

            <input
            wire:model.live.debounce.500ms="search"
            id="search" name="search" type="search"
            class="block w-full rounded-md border-0 bg-blue-800 bg-opacity-25 py-1.5 pl-10 pr-3 text-indigo-100 placeholder:text-indigo-200 focus:bg-white focus:text-gray-900 focus:outline-none focus:ring-0 focus:placeholder:text-gray-400 sm:text-sm sm:leading-6"
            placeholder="Search for Laravel packages, apps and tools">

            <div>
                <div class="@if( !$search ) hidden @endif px-6 mx-auto max-w-7xl lg:px-8">
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

                    <div class="pt-10 mt-5">
                        {{ $items   ->links() }}
                    </div>
                </div>

              </div>
        </div>

        <div id="solarSystem"></div>

        <div id="footer">
            <div id="space-pilgrim">
                <img id="space-pilgrim-image" src="planets/space-pilgrim.png" />
            </div>
        <div id="menu">
            <div id="link"><a href="submit">Submit</a></div>
            <div id="link"><a href="about">About</a></div>
            <div id="link"><a href="contact">Contact</a></div>
        </div>
        </div>
    </div>

    <script>

    function initializeThreeJS() {

        var scene = new THREE.Scene();

        var camera = new THREE.PerspectiveCamera(
            75,
            window.innerWidth / window.innerHeight,
            0.1,
            1000
        );

        var renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);

        document.getElementById("solarSystem").appendChild(renderer.domElement);

        var loader = new THREE.TextureLoader();
        var backgroundTexture = loader.load("planets/backgrounds.jpg");



        var aspectRatio = 2240 / 1592;
        var bgHeight = 50;
        var bgWidth = bgHeight * aspectRatio;
        var backgroundGeometry = new THREE.PlaneGeometry(
            bgWidth,
            bgHeight,
            1,
            1
        );
        var backgroundMaterial = new THREE.MeshBasicMaterial({
            map: backgroundTexture,
            side: THREE.DoubleSide,
        });
        var backgroundMesh = new THREE.Mesh(
            backgroundGeometry,
            backgroundMaterial
        );
        backgroundMesh.position.z = -50;
        scene.add(backgroundMesh);

        var directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(1, 1, 5);
        scene.add(directionalLight);

        camera.position.z = 25;
        const pointLight = new THREE.PointLight(0xF7B05B, 1, 100);
        pointLight.position.set(0, 0, 0);
        scene.add(pointLight);

        @php (
            $planets = [
                'laravel' => [
                    'texture' => 'planets/laravel.jpg',
                    'geometry' => '1.3, 32, 32',
                    'opacity' => '1',
                    'position' => '2, 2, 0',
                    'rotation' => ' -= 0.003',
                    'redirect' => 'laravel'
                ],
                'filament' => [
                    'texture' => 'planets/filament.jpg',
                    'geometry' => '0.6, 32, 32',
                    'opacity' => '1',
                    'position' => '-0.6, -0.3, 0',
                    'rotation' => '-= 0.009',
                    'redirect' => 'filament'
                ],
                'livewire' => [
                    'texture' => 'planets/livewire.jpg',
                    'geometry' => '1, 32, 32',
                    'opacity' => '1',
                    'position' => '-4, 2, 0',
                    'rotation' => '-= 0.007',
                    'redirect' => 'livewire'
                ],
                'inertia' => [
                    'texture' => 'planets/inertia.jpg',
                    'geometry' => '0.8, 32, 32',
                    'opacity' => '1',
                    'position' => '-3, -3, 0',
                    'rotation' => '-= 0.004',
                    'redirect' => 'inertia'
                ],
                'php' => [
                    'texture' => 'planets/php.jpg',
                    'geometry' => '1, 32, 32',
                    'opacity' => '1',
                    'position' => '4.5, 0.5, 0',
                    'rotation' => '-= 0.001',
                    'redirect' => 'php'
                ],
                'vue' => [
                    'texture' => 'planets/vue.jpg',
                    'geometry' => '0.7, 32, 32',
                    'opacity' => '1',
                    'position' => '-5, -1, 0',
                    'rotation' => '-= 0.004',
                    'redirect' => 'vue'
                ],
                'react' => [
                    'texture' => 'planets/vue.jpg',
                    'geometry' => '0.3, 32, 32',
                    'opacity' => '1',
                    'position' => '-6, 3, 0',
                    'rotation' => '-= 0.004',
                    'redirect' => 'react'
                ],
                'svelte' => [
                    'texture' => 'planets/vue.jpg',
                    'geometry' => '0.4, 32, 32',
                    'opacity' => '1',
                    'position' => '-7, 1, 0',
                    'rotation' => '-= 0.004',
                    'redirect' => 'svelte'
                ]
            ]
        )

        @foreach ($planets as $planet => $data)

            var {{ $planet }}Texture = loader.load("{{ $data['texture'] }}");
            var {{ $planet }} = new THREE.Mesh(
                new THREE.SphereGeometry({{ $data['geometry'] }}),
                new THREE.MeshPhongMaterial({
                map: {{ $planet }}Texture,
                transparent: true,
                opacity: {{ $data['opacity'] }},
                })
            );
            {{ $planet }}.name = "planet";
            {{ $planet }}.position.set({{ $data['position'] }});
            scene.add({{ $planet }});

        @endforeach

        function adjustCamera() {
            var windowAspectRatio = window.innerWidth / window.innerHeight;
            var imageAspectRatio = aspectRatio;
            if (windowAspectRatio > imageAspectRatio) {
            var fov = 2 * Math.atan(bgHeight / 2 / 100) * (180 / Math.PI);
            camera.fov = fov;
            } else {
            var fov =
                2 * Math.atan(bgWidth / (2 * aspectRatio) / 100) * (180 / Math.PI);
            camera.fov = fov;
            }
            camera.updateProjectionMatrix();
        }

        adjustCamera();

        window.addEventListener("resize", () => {
            var width = window.innerWidth;
            var height = window.innerHeight;
            renderer.setSize(width, height);
            camera.aspect = width / height;
            adjustCamera();
            camera.updateProjectionMatrix();
        });

        const stars = [];
        const starGeometry = new THREE.SphereGeometry(0.01, 16, 16);
        const starMaterial = new THREE.MeshBasicMaterial({ color: 0xffffff });

        for (let i = 0; i < 2000; i++) {
        const star = new THREE.Mesh(starGeometry, starMaterial);
        star.position.set(
            Math.random() * 20 - 10,
            Math.random() * 30 - 10,
            Math.random() * 20 - 20
        );
        scene.add(star);
        stars.push(star);
        }

        pointsMaterial = new THREE.PointsMaterial({ size: 0.05, vertexColors: true });

        function updateStars() {
            stars.forEach(star => {
                const scale = (0.7 + 0.3 * Math.sin(0.9 * star.position.x + Date.now() * 0.001));
                star.scale.set(scale, scale, scale);
            });
        }

        function createShootingStar() {
            const geometry = new THREE.SphereGeometry(0.02, 8, 8);
            const material = new THREE.MeshStandardMaterial({ color: 0xffffff, transparent: true });
            const star = new THREE.Mesh(geometry, material);
            star.material.opacity = 0.2;
            scene.add(star);

            const startPos = { x: Math.random() * 10 - 5, y: Math.random() * 10 + 5, z: Math.random() * 10 - 5 };
            const endPos = { x: Math.random() * 10 - 5, y: Math.random() * 10 - 5, z: Math.random() * 10 - 5 };

            let tl = gsap.timeline({
                onComplete: () => scene.remove(star)
            });

            tl.to(star.position, {
                x: endPos.x,
                y: endPos.y,
                z: endPos.z,
                duration: 2,
                ease: "power4.inOut"
            }, 0)
            .fromTo(star.material, { opacity: 0 }, { opacity: 1, duration: 1, ease: "power2.inOut"}, 0)
            .to(star.material, { opacity: 0, duration: 1, ease: "power2.inOut"}, "<1");
        }

        function randomShootingStar() {
        setTimeout(() => {
            createShootingStar();
            randomShootingStar();
        }, Math.random() * 5000 + 1000);
        }

        randomShootingStar();

        function animate() {
            requestAnimationFrame(animate);
            @foreach ($planets as $planet => $data)

                {{ $planet }}.rotation.y {{ $data['rotation'] }};

            @endforeach

            updateStars();

            renderer.render(scene, camera);
        }

        animate();

        var oldx = 0;
        var oldy = 0;
        window.onmousemove = function (ev) {
            var changex = ev.x - oldx;
            var changey = ev.y - oldy;
            camera.position.x += changex / 1000;
            camera.position.y -= changey / 1000;

            oldx = ev.x;
            oldy = ev.y;
        };

        var raycaster = new THREE.Raycaster();
        var mouse = new THREE.Vector2();

        function onMouseMove(event) {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

            raycaster.setFromCamera(mouse, camera);

            var intersects = raycaster.intersectObjects(scene.children);

            scene.children.forEach((planet) => {
            planet.scale.set(1, 1, 1);
            });

            if (intersects.length > 0) {
            var [intersect] = intersects;
            if (intersect.object.name === "planet") {
                intersect.object.scale.set(1.1, 1.1, 1.1);
            }
            }
        }

        function zoomAndRedirect(planet, url) {
            var targetPosition = planet.position
            .clone()
            .add(new THREE.Vector3(0, 0, 1));

            var tl = gsap.timeline({
                onComplete: () => {

                    @this.call('jump', url);

                },
            });

            tl.to(camera.position, {
            x: targetPosition.x,
            y: targetPosition.y,
            z: targetPosition.z,
            duration: 2,
            });
            tl.to(camera.rotation, { x: 0, y: 0, z: 0, duration: 2 }, 0);

            return tl;
        }

        function onMouseClick(event) {
            raycaster.setFromCamera(mouse, camera);

            var intersects = raycaster.intersectObjects(scene.children);

            if (intersects.length > 0) {
            var [intersect] = intersects;
            var planet = intersect.object;

            switch (planet) {
                @foreach ($planets as $planet => $data)

                    case {{ $planet }}:
                        zoomAndRedirect(planet, "{{ $data['redirect'] }}");
                        break;

                @endforeach
            }
        }
    }

    window.addEventListener("mousemove", onMouseMove, false);
    window.addEventListener("click", onMouseClick, false);

    }

    setTimeout(function(){
        gsap.to("#space-pilgrim", {
            duration: 2,
            opacity: 1,
            ease: "power2.out"
        });
    }, 4000);

    initializeThreeJS();

    window.addEventListener("popstate", function (event) { window.location.reload(); });

    </script>
