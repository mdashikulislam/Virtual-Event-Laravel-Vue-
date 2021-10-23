
<template>
    <div class="login-page">
        <div class="login">
            <div class="register-container auth-container">
                <div class="register-image-column">
                    <div class="image-holder">
                        <img src="#" alt="">
                    </div>
                </div>

                <div class="register-form-column">
                    <form v-on:submit.prevent="createEvent">
                        <h3>Create an Event</h3>
                        <div class="form-wrapper">
                            <label for="title"> Title </label>
                            <input type="text" name="title" id="title" v-model="title" placeholder="Enter title of event" class="form-control" required>
                        </div>

                        <div class="form-wrapper">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" v-model="description" placeholder="Enter Description" class="form-control" required>
                        </div>

                        <div class="form-wrapper">
                            <label for="youtube_url">Youtube Link (Valid URL)</label>
                            <input type="url" name="youtube_url" id="youtube_url" v-model="youtube_url" placeholder="Enter valid Youtube URL" class="form-control" required>
                        </div>
                        <button type="submit" class="mt-3">CREATE &nbsp;&nbsp;<span v-if="showSpinner" class="fa fa-spin fa-spinner"></span> </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    name: "CreateEvent",
    props: ['route'],
    data() {
        return {
            title: "",
            description: "",
            youtube_url: '',
            showSpinner: false,
        };
    },
    methods: {
        createEvent() {
            if (this.title && this.description && this.youtube_url) {
                this.showSpinner = true;
                let guid = Math.random().toString(36).substring(7);

                let data = {
                    guid,
                    title: this.title,
                    description: this.description,
                    youtube_url: this.youtube_url
                }

                axios.post(`${this.route}/create`, data)
                    .then(response => {
                        console.log("Event created successfully", response.data);
                        this.redirect();
                    }).catch(error => {
                    console.log(error.response.data.message);
                })
            } else {
                alert("Please fill all the fields")
            }
        },
        redirect() {
            window.location.href = `${this.route}/home`;
        }
    }
};
</script>
