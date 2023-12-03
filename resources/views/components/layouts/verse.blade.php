<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Laraverse</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap"
      rel="stylesheet"
    />

    <style>
      body {
        margin: 0;
        overflow: hidden;
      }
      #canvas {
        width: 100%;
        height: 100%;
        margin: 0;
      }
      #solarSystem {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
      }
      #header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: start;
      }
      #footer {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 9;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: end;
      }
      #menu {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 20px;
      }
      #link {
        margin: 20px;
        font-size: 20px;
        font-family: "Noto Sans", sans-serif;
        color: white;
      }
      #logo {
        margin: 15px;
        font-size: 40px;
        font-family: "Noto Sans", sans-serif;
        color: white;
      }
      #search {
        pointer-events: auto;
        font-family: "Noto Sans", sans-serif;
        width: 50%;
      }
      #space-pilgrim {
        position: fixed;
        top: 59%;
        opacity: 0;
      }

    </style>

    <script src="https://unpkg.com/three@0.132.2/build/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>

    @livewireStyles

    @vite(['resources/css/app.css', 'resources/js/app.js'])

  </head>
    <body class="antialiased">

        {{ $slot }}

        @livewireScripts

    </body>
</html>
