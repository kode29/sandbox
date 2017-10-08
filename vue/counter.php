<!doctype html>
<html lang="en">
  <head>
    <title>Vue Counter</title>
    <script src="https://unpkg.com/vue"></script>
    </head>
    <body>
    <div id="app">
  <div>{{ counter }}</div>
  <button v-on:click="increment">Increment</button>
</div>
<script>
  new Vue({
    el: '#app',
    data: {
      counter: 0
    },
    methods: {
      increment() {
        this.counter+=Math.round(Math.random()*10);
      }
    }
  });
</script>
</body>
</html>
