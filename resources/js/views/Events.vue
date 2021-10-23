
<template>
    <div class="container">
        <div class="row">
            <ul class="list img-list">
                <li :key="event.id" v-for="event in events">
                    <a href="#" class="inner" v-on:click.prevent="redirectAndViewEvent(event.cometchat_group_id)">
                        <div class="li-img">
                            <img :src="getVideoThumbnail(event.youtube_url)" :alt="event.description" />
                        </div>
                        <div class="li-text">
                            <h3 class="li-head">{{event.title}}</h3>
                            <div class="li-sub">
                                <p>{{event.description}}</p>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>


<script>
import {CometChat} from "@cometchat-pro/chat";

export default {
    name: "Events",
    props: ['route'],
    data() {
        return {
            events: [],
            showSpinner: false,
        };
    },
    created() {
        axios.get(`${this.route}/events`)
            .then((response) => {
                this.events = response.data.events;
                console.log(response.data.events);
            })
            .catch((error) => {
                console.log(error);
            })
    },
    methods: {
        getVideoThumbnail(url) {
            let regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            let match = url.match(regExp);
            if (match && match[2].length == 11) {
                return `https://img.youtube.com/vi/${match[2]}/0.jpg`;
            } else {
                //error
            }
        },
        async redirectAndViewEvent(id) {
            try {
                const group = await CometChat.getGroup(id);
                console.log(group);
                if (group.hasJoined === false) {
                    const response = await CometChat.joinGroup(id, CometChat.GROUP_TYPE.PUBLIC, "");
                    console.log(
                        "Group joining success with response:",
                        response
                    );
                    window.location.href = `${this.route}/view-single-event/${id}`
                } else {
                    window.location.href = `${this.route}/view-single-event/${id}`
                }
            } catch (error) {
                console.log("Group joining failed with exception:", error);
            }
        }
    }
}
</script>



<style scoped>
.list {
    max-width: 1400px;
    margin: 20px auto;
}

.img-list a {
    text-decoration: none;
}

.li-sub p {
    margin: 0;
}

.list li {
    border-bottom: 1px solid #ccc;
    display: table;
    border-collapse: collapse;
    width: 100%;
}
.inner {
    display: table-row;
    overflow: hidden;
}
.li-img {
    display: table-cell;
    vertical-align: middle;
    width: 30%;
    padding-right: 1em;
}
.li-img img {
    display: block;
    width: 100%;
    height: auto;

}
.li-text {
    display: table-cell;
    vertical-align: middle;
    width: 70%;
}
.li-head {
    margin: 10px 0 0 0;
}
.li-sub {
    margin: 0;
}

@media all and (min-width: 45em) {
    .list li {
        float: left;
        width: 50%;
    }
}

@media all and (min-width: 75em) {
    .list li {
        width: 33.33333%;
    }
}

/* for flexbox */
@supports(display: flex) {
    .list {
        display: flex;
        flex-wrap: wrap;
    }

    .li-img,
    .li-text,
    .list li {
        display: block;
        float: none;
    }

    .li-img {
        align-self: center; /* to match the middle alignment of the original */
    }

    .inner {
        display: flex;
    }
}

/* for grid */
@supports(display: grid) {
    .list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    }

    .list li {
        width: auto; /* this overrides the media queries */
    }
}
</style>
