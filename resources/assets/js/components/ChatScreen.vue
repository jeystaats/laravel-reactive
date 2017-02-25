<template>
    <div>
    <div class="chat">
            <div class="chat-history">
                    <ul>
                         <li v-for='message in messages'>
                                        <div class="message-data">
                                            <span class="message-data-name">
                                                <span v-text="message.user" />
                                            </span>
                                            <span class="message-data-time">
                                                
                                            </span>
                                        </div>
                                        <div class="message my-message" v-bind:style="{ background: '#' + intToRGB(hashCode(message.user)) ,  }">
                                            {{ message.text }} 
                                        </div>
                        </li>
                     </ul>
             </div>
             <div class="chat-message clearfix">
             <textarea @keyup.enter="postMessage()"  v-model="message"></textarea>
             <button @click="postMessage()" class="btn btn-success">Plaats bericht</button>
            </div>
            </div>
    </div>
</template>

<script>
    export default{
        data() {
            return {
                message: '',
                messages: [],
            }
        },
        mounted() {
            Echo.channel('messages')
                .listen('.messagePosted', (data) => {
                    this.messages.push(data);
                });
        },

        methods: {
            postMessage() {
                axios.post('/postmessage', {'message': this.message}).then((response) => {
                    this.message = '';
                }, (response) => {
                });
            },
            hashCode(str) { // java String#hashCode
                var hash = 0;
                for (var i = 0; i < str.length; i++) {
                   hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                return hash;
            },
            intToRGB(i){
                var c = (i & 0x00FFFFFF)
                    .toString(16)
                    .toUpperCase();

                return "00000".substring(0, 6 - c.length) + c;
            }
        }
    }
</script>
