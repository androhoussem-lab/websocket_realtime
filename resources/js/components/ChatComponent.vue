<template>
    <div class="row">

        <div class="col-8">
            <div class="card card-default">
                <div class="card-header" style="background-color:purple;color:white;">Messages</div>
                <div class="card-body p-0">
                     <ul class="list-instyled" style="height : 300px;overflow-y:scroll;" v-chat-scroll>
                        <li class="p-2" v-for="(message , index) in messages" :key="index" >
                            <b style="color:purple;">{{message.user.name}}</b> :
                            {{message.message}}
                            <span style="display:block;">{{message.formatTimeForHuman}}</span>
                            </li>
                    </ul>
                </div>

            </div>
            <input name="message" v-model="newMessage" @keyup="sendTypingEvent" @keyup.enter="sendMessage" class="form-control" type="text" placeholder="Enter your message...">
            <input name="user_id" type="hidden" :value="id">
            <span class="text-muted" v-if="activeUser">{{activeUser.name}} is typing</span>
        </div>
        <div class="col-4">
            <div class="card card-default" >
                <div class="card-header" style="background-color:purple;color:white;">User Active</div>
                <div class="card-body p-0">
                    <ul class="list-instyled" style="height : 300px;overflow-y:scroll;">
                        <li class="p-2" v-for="(user,index) in users" :key="index">
                            {{user.name}}
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props :['user'],
        data : function (){
            return {
                id : this.user.id,
                messages : [] ,
                newMessage : '' ,
                users : [],
                activeUser : false,
            };
        },
        created : function (){
            this.fetchMessages();
            Echo.join('Chat-Channel')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id =! user.id);
                })
                .listen('SendMessageEvent' , (event) => {
                    this.messages.push(event.message);

                })
                .listenForWhisper('typing',user => {
                    this.activeUser = user;
                     setTimeout(() => {
                    this.activeUser = false;
                }, 3000);
                });

        },
        methods : {
            fetchMessages(){
                axios.get('api/messages').then(response => {
                     this.messages = response.data;
                });
            },
            sendMessage(){
                this.messages.push({
                    user : this.user,
                    message : this.newMessage,
                });
                axios.post('api/messages' , {user_id : this.id ,message : this.newMessage , });
                this.newMessage ='';
            },
            sendTypingEvent(){
                Echo.join('Chat-Channel')
                    .whisper('typing',this.user);
            }
        }
    }
</script>
