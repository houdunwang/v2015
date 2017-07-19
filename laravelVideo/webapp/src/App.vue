<template>
  <div id="app">
    <transition enter-active-class="animated tada">
    <router-view></router-view>
      </transition>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>