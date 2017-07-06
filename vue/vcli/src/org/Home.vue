<template>
    <div class="home">
        <h1>这是主页....</h1>
        <li v-for="v in news">
            {{v.id}} - {{v.title}}
        </li>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                news:[
                    {id:1,title:'hdcms'},
                    {id:2,title:'hdphp'}
                ]
            }
        }
    }
</script>