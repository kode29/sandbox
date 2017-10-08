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

  <body onload="init()">
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
    //HTML5 Local Storage
    function init() {
      vueDB.webdb.open();
      vueDB.webdb.createTable();
    }

    //Prereq setup
    var vueDB = {};
    vueDB.webdb = {};

    //Initial setup
    vueDB.webdb.open = function(){
      var dbSize = 2 * 1024 * 1024; //2MB
      // DB Setup: name, Version, Description, Size
      vueDB.webdb.db = openDatabase("Todo", "1", "Todo Manager", dbSize);
    }

    // Checking
    vueDB.webdb.onError = function(tx, e){
      alert("There was an error setting up the local database: " + e.message);
    }

    // Success
    vueDB.webdb.onSuccess = function(tx, r){
      //re-render the data
      //vueDB.webdb.getAllTodoItems(loadTodoItems);
    }

    vueDB.webdb.createTable = function() {
      var db = vueDB.webdb.db;
      db.transaction(function(tx) {
      tx.executeSql("CREATE TABLE IF NOT EXISTS " +
                "todo(ID INTEGER PRIMARY KEY ASC, todo TEXT, added_on DATETIME)", []);
      });
    }

//    vueDB.webdb.getAllTodoItems = function(renderFunc) {
//  var db = vueDB.webdb.db;
//  db.transaction(function(tx) {
//    tx.executeSql("SELECT * FROM todo", [], renderFunc,
//        vueDB.webdb.onError);
//  });
//}

vueDB.webdb.addTodo = function(todoText) {
  var db = vueDB.webdb.db;
  db.transaction(function(tx){
    var addedOn = new Date();
    tx.executeSql("INSERT INTO todo(todo, added_on) VALUES (?,?)",
      [todoText, addedOn],
      vueDB.webdb.onSuccess,
      vueDB.webdb.onError);
  });
}


    // Begin Vue.js

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
          var i = this.newItem

          // Push to the array
          tdList.todos.push({ text: i })

          // Reset the field (attaches to "data")
          this.newItem = "";

          vueDB.webdb.addTodo(i)
        }
      }
    })


    </script>
  </body>
</html>
