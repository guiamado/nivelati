import firebase from "firebase";
import 'firebase/auth';
// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyBUef0cAGlfvnRFoDvTiptJcnyi4SubdLc",
    authDomain: "nivelati.firebaseapp.com",
    databaseURL: "https://nivelati-default-rtdb.firebaseio.com",
    projectId: "nivelati",
    storageBucket: "nivelati.appspot.com",
    messagingSenderId: "507809773284",
    appId: "1:507809773284:web:9a459412460776dd0ddef1",
    measurementId: "G-J70TR408DP"
};

// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();

const authFirebase = firebase.auth()
const db = firebase.firestore();
const indexCollection = db.collection('index');
const providerMicrosoft = new firebase.auth.OAuthProvider('microsoft.com');
// providerMicrosoft.addScope('mail.read');
// providerMicrosoft.addScope('profile.read');

export {
    authFirebase,
    db,
    indexCollection,
    providerMicrosoft,
};
// export default firebase.initializeApp(firebaseConfig);