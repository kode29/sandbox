<!--
Vue Basic Project: Todo List
Author: @kode29
Date: 2017-10-08

Resources:
https://coligo.io/vuejs-the-basics/
https://vuejs.org/v2/guide/#Handling-User-Input
https://medium.freecodecamp.org/vue-js-introduction-for-people-who-know-just-enough-jquery-to-get-by-eab5aa193d77

TODO:
Add localStorage system for keeping todo items and retrieving 
-->
<!doctype html>
<html lang="en">
  <head>
    <title>TODO in Vue</title>
    <meta charset="utf-8"/>
    <script src="https://unpkg.com/vue"></script>

  </head>

  <body>
    <div id="todo-list">
      <ol>
        <todo-item
          v-for="item in todos"
          v-bind:todo="item"
          v-bind:key="item.id">
        </todo-item>
      </ol>
    </div>

    <div id="add">
      <input type="text" id="item" name="item" v-on:keyup.enter="addItem" placeholder="Enter Item" v-model="newItem"/>
    </div>


    <script>
    Vue.component('todo-item', {
      props: ['todo'],
      template: '<li>{{ todo.text }}</li>'
    })

    var tdList = new Vue({
      el: '#todo-list',
      data: {
        // Generate a blank array
        todos: []
      }
    })

    var itemBox = new Vue({
      el: '#item',
      data: {
        // This is necessary for identifying what we're working with
        newItem: ''
      },
      methods: {
        addItem: function(){
          // Basic function setup

          // Push to the array
          tdList.todos.push({ text: this.newItem })

          // Reset the field (attaches to "data")
          this.newItem = "";
        }
      }
    })


    </script>
  </body>
</html>
