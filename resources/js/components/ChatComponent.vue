<template>
    <div class="row">
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Users</div>

                <div class="card-body p-0">
                    <ul class="ul-unstyled" style="height:400px;">
                        <li class="py-2" v-for="(user, index) in users" :key="index">
                            <img :title="user.name" :src="avatar" height="30" > {{ user.name }}
                        </li>
                    </ul> 
                </div>
            </div>
            
        </div>
        <div class="col-8">
             <div class="card card-default">
                <div class="card-header">Messages</div>

                <div class="card-body p-0">
                    <ul  style="height:400px; overflow-y:auto" v-chat-scroll>
                        <li class="p-2 row" v-for="(message,index) in messages" :key="index" style="margin:0;">
                            <div class="col-1" >
                                <img :title="message.user.name" :src="avatar" height="30" >
                            </div>
                            <div class="col-11">
                                <span class="message-body">{{message.message}} </span> <br>
                                <span class="time-ago">
                                    <timeago :datetime="message.created_at"></timeago>
                                </span>
                            </div>
                             
                            
                        </li>
                    </ul> 
                </div> 
                <input
                    @keyup.enter="sendMessage"
                    v-model="newMessage" 
                    type="text" 
                    name="message" 
                    placeholder="Enter your message......" 
                    class="form-control">
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        props:['user'],

        data(){
            return {
                messages: [],
                newMessage: '',
                users:[],
                avatar: 'img/user.png',
                title: 'User'
            }
        },

        created(){
            this.fetchMessage();

            Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                });
        },

        methods:{
            fetchMessage: function(){
                axios.get('messages').then(response => {
                    this.messages = response.data;
                });
            },
            sendMessage() {

                this.messages.push({
                    user: this.user,
                    message: this.newMessage,
                    created_at: new Date()
                });

                axios.post('messages', {message: this.newMessage});

                this.newMessage = '';
            },
        }
    }
</script>
