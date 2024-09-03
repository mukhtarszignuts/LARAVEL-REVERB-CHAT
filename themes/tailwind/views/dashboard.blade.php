<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($users as $user)
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <a href="{{ route('chat', $user) }}">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                </div>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="module">
    // Import the Firebase functions you need
    import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.3.1/firebase-app.js';
    import { getMessaging, getToken, onMessage } from 'https://www.gstatic.com/firebasejs/10.3.1/firebase-messaging.js';

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
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    // Request permission to send notifications
    Notification.requestPermission().then(permission => {
        if (permission === 'granted') {
            console.log('Notification permission granted.');

            // Get FCM token
            getToken(messaging, { vapidKey: "BHkT6xZ7qU9XPhDbXzxcN6V5MPJZi_RuaIuJTbQ-BFQGYvF2OYJ1oehW3UoK_zn6kc99t5pJTDKElVKC6OLFPOo" }).then((currentToken) => {
                if (currentToken) {
                    console.log('FCM Token:', currentToken);
                    // Send the token to your server or save it
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: currentToken
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        alert('Token saved successfully.');
                    },
                    error: function (err) {
                        console.log('User Chat Token Error'+ err);
                    },
                });
                } else {
                    console.log('No registration token available.');
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
            });

        } else {
            console.log('Unable to get permission to notify.');
        }
    });

    // Handle incoming messages
    onMessage(messaging, (payload) => {
        console.log('Message received. ', payload);
        // Customize notification here
        const notificationTitle = payload.notification.title;
        const notificationOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon
        };

        new Notification(notificationTitle, notificationOptions);
    });
</script>


</x-app-layout>
