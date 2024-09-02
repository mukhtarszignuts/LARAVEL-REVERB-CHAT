<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @vite(['themes/tailwind/css/app.css', 'themes/tailwind/js/app.js'], 'tailwind')
        <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script>
    
    // Your web app's Firebase configuration
    const firebaseConfig = {
      apiKey: "AIzaSyCCyk1vXRAnlJsVQO4JoCAP08hqTxzlkjY",
      authDomain: "vue-laravel-a0c98.firebaseapp.com",
      databaseURL: "https://vue-laravel-a0c98-default-rtdb.firebaseio.com",
      projectId: "vue-laravel-a0c98",
      storageBucket: "vue-laravel-a0c98.appspot.com",
      messagingSenderId: "673727381742",
      appId: "1:673727381742:web:360512e4bf030f025eb3ff",
      measurementId: "G-JDDZZDG2Z3"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
            messaging
            .requestPermission()
            .then(function () {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);
                alert(token)
               

            }).catch(function (err) {
                console.log('User Chat Token Error'+ err);
            });
     }

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            
        new Notification(noteTitle, noteOptions);
        
        });

  </script>
    </head>
    <body class="font-sans antialiased">
        <div id="app" class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
