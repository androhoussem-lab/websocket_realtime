<template>
    <div class="row">
        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Messages</div>
                <div class="card-body p-0">
                     <ul class="list-instyled" style="height : 300px;overflow-y:scroll;">
                        <li class="p-2" v-for="(message , index) in messages" :key="index">
                            <b>{{ message.user.name }}</b> :
                            {{message.message}}
                            </li>
                    </ul>
                </div>

            </div>
            <input name="message" v-model="newMessage" @keyup.enter="sendMessage" class="form-control" type="text" placeholder="Enter your message...">
            <span class="text-muted">User is typing...</span>
        </div>
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">User Active</div>
                <div class="card-body p-0">

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
                messages : [] ,
                newMessage : ''
            };
        },
        created : function (){
            this.fetchMessages();
        },
        methods : {
            fetchMessages(){
                axios.get('/messages').then(response => {
                     this.messages = response.data;
                });
            },
            sendMessage(){
                this.messages.push({
                    user : this.user,
                    message : this.newMessage,
                });
                axios.post('/messages' , {message : this.newMessage});
                this.newMessage ='';
            }
        }
    }
</script>
