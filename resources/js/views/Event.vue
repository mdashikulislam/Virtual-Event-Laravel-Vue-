<template>
    <div>
        <div class="video-container">
        </div>

        <div class="row">
            <div class="col-md-8">
                <iframe width="100%" height="500" :src="this.video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                <div class="video-info-container">
                    <div class="video-description">
                        <h4 class="text-left">{{ event.title }}</h4>
                        <span class="date sub-text">{{ getCreatedDate(event.created_at) }}</span>
                    </div>

                    <div class="video-actions sub-text">
                        <div class="action-item">
                            <i class="fas fa-thumbs-up"></i> 1000
                        </div>
                        <div class="action-item">
                            <i class="fas fa-thumbs-down"></i> 150
                        </div>
                        <div class="action-item">
                            <i class="fas fa-share"></i> Share
                        </div>
                        <div class="action-item">
                            <i class="fas fa-save"></i> Save
                        </div>
                        <div class="action-item">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </div>
                </div>

                <div class="subscription-container">
                    <div class="account-container">
                        <div class="icon-container">
                            <i class="fab fa-youtube"></i>
                        </div>
                        <div>
                            <div>
                                <strong>YouTube</strong>
                            </div>

                            <div>
                                <span class="small-text sub-text">200 subscribers</span>
                            </div>
                        </div>

                    </div>
                    <div class="subscribe-container">
                        <button class="btn btn-danger">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-5">
                <comet-chat-messages type="group" :item="groupEvent"></comet-chat-messages>

            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import  { CometChatMessages }  from "../cometchat-pro-vue-ui-kit/CometChatWorkspace/src/";
import {CometChat} from "@cometchat-pro/chat";

export default {
    name: "Event",
    props: ['id','route'],
    components: {
        CometChatMessages,
    },
    data() {
        return {
            event: {},
            video: "",
            groupEvent: {}
        }
    },
    async mounted() {
        console.dir(this.id);
        const group = await CometChat.getGroup(this.id);
        this.groupEvent = group;
        console.log(group);
        axios.get(`${this.route}/event/${this.id}`)
            .then((response) => {
                console.log(response.data.event);
                this.event = response.data.event;
                this.video = this.getVideoUrl(this.event.youtube_url);
            })
            .catch((error) => {
                console.log(error);
            })
    },
    methods: {
        getVideoUrl(url) {
            let regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            let match = url.match(regExp);
            console.log(match)
            if (match && match[2].length == 11) {
                return `https://www.youtube.com/embed/${match[2]}`;
            } else {
                //error
            }
        },
        getCreatedDate(date) {
            return moment(date).format('MMMM d, Y')
        }
    }
}
</script>

<style scoped>
.video-info-container{
    display:flex;
    flex-direction:row;
    justify-content:space-between;
    border-bottom:1px solid #ececec;
    padding:10px 0
}
.video-actions{
    display:flex;
    flex-direction:row
}
.action-item{
    padding:0 10px;
    align-self:flex-end
}
.sub-text{
    color:#909090
}
.subscription-container{
    display:flex;
    flex-direction:row;
    justify-content:space-between;
    align-items:flex-end;
    padding:10px 0
}
.icon-container .fab{
    font-size:45px
}
.account-container{
    display:flex;
    flex-direction:row
}
.small-text{
    font-size:12px
}
.icon-container{
    padding-right:10px;
    color:#e43d32
}
</style>
