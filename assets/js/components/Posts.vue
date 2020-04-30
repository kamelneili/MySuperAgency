<template>
    
<div>
     <div v-for="post in posts" :key="post.id">
         {{post}}
        </div> 
    <h3 class="text-center" v-if="loading">Loading posts ...</h3>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        data () {
            return {
                posts : [],
                total : 0,   
                offset : 0,
                loading : true
            }
        },
       mounted () 
        {
    var self = this;
      axios.get('/api/getposts').then(response =>{
      self.posts = response.data;
     
      
            this.total = response.data.total;
            this.offset = response.posts.length;
            this.loading = false;
             console.log(response.data);
             window.addEventListener('scroll',(e) =>{
                 if(window.innerHeight+window.pageYOffset >= document.body.offsetHeight)
                 {
                     this.loading=true
                     let {data} = axios.get('/api/getposts/' + this.offset)
                     this.posts=[...this.posts, ...data.posts]
                      console.log([...this.posts, ...data.posts]);
                     this.offset += data.posts.length
                     this.loading=false
                 }
             })
  })
        }
    }
    
</script>
