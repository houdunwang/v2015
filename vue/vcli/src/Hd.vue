<template>
    <div id="app">
        <h1>这是hdvue组件 <span>hdphp.com</span></h1>
        <li v-for="v in goods">
            {{v.title}}
        </li>
        <hr>
        <li v-for="v in users">
            {{v.name}}
        </li>
    </div>
</template>
<script>
    import Home from './org/Home'
    export default {
        name: 'hd',
        components: {Home},
        computed: {
            goods(){
                return this.$store.getters.getAllNews;
            },
            users(){
                return this.$store.getters.getUsers;
            }
        }
    }
</script>
<style lang="less" scoped="">
    body {
        h1 {
            background: red;
            color: yellow;
            span {
                color: #fff;
            }
        }
    }
</style>