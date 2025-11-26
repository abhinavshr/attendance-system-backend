<script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-messaging.js"></script>

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

messaging.onMessage((payload) => {
    console.log("Message received: ", payload);
    alert(payload.notification.title + " - " + payload.notification.body);
});
</script>
