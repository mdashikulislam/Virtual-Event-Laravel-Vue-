require('./bootstrap');

window.Vue = require('vue').default;

import { CometChat } from "@cometchat-pro/chat/CometChat";

Vue.component('login-component', require('./views/Login.vue').default);
Vue.component('register-component', require('./views/Register.vue').default);
Vue.component('events-component', require('./views/Events.vue').default);
Vue.component('event-component', require('./views/Event.vue').default);
Vue.component('create-event-component', require('./views/CreateEvent.vue').default);


let cometChatAppSetting = new CometChat.AppSettingsBuilder()
    .subscribePresenceForAllUsers()
    .setRegion(process.env.MIX_COMMETCHAT_APP_REGION)
    .build();

CometChat.init(process.env.MIX_COMMETCHAT_APP_ID, cometChatAppSetting).then(
    () => {
        console.log("Initialization completed successfully");

        const app = new Vue({
            el: '#app',
        });
    },
    (error) => {
        console.log("Initialization failed with error:", error);
    }
);
