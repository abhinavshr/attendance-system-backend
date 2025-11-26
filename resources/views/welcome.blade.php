<script>
const firebaseConfig = {
   apiKey: "...",
   authDomain: "...",
   projectId: "...",
   messagingSenderId: "...",
   appId: "..."
};

const app = firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

// Request permission and get token
messaging.requestPermission()
.then(() => messaging.getToken({ vapidKey: 'YOUR_PUBLIC_VAPID_KEY' }))
.then((token) => {
    console.log('FCM Token:', token);

    // Send token to Laravel backend
    fetch('/api/save-fcm-token', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer {{ auth()->user()->createToken("API Token")->plainTextToken ?? "" }}'
        },
        body: JSON.stringify({ fcm_token: token })
    });
})
.catch((err) => console.log('Error getting FCM token', err));

// Listen for messages when page is open
messaging.onMessage((payload) => {
    console.log("Message received: ", payload);
    alert(payload.notification.title + " - " + payload.notification.body);
});
</script>
