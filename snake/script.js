$(function(){
  //Define vars
    var canvas = $('#canvas')[0];
    var ctx = canvas.getContext("2d");
    var w = canvas.width;
    var h = canvas.height;
    var cw = 15;
    var d = "right"; //Direction
    var food, score;
    var speed = 100; // Speed is set in Interval(), so lower=faster
    var color = "green";
    
    //Snake Array
    var snakeArray;
    
    // Initializer
    function init(){
        createSnake();
        createFood();
        score = 0;
        d = "right";
        
        if(typeof gameLoop != "undefined"){
            clearInterval(gameLoop);
        }
        gameLoop = setInterval(paint, speed);
    }
    
    init(); //Run Initializer

    // Create snake
    function createSnake(){
        var length = 5;
        snakeArray = [];
        for(var i = length-1; i >= 0; i--){
            snakeArray.push({x:i , y:0});
        }
    }
    
    //Create Food
    function createFood(){
        food = {
            x:Math.round(Math.random()*(w-cw)/cw),
            y:Math.round(Math.random()*(h-cw)/cw)
        };
    }
    
    //Paint Snake
    function paint(){
        // Paint the canvas
        ctx.fillStyle = "black";
        ctx.fillRect(0,0,w,h);
        ctx.strokeStyle = "white";
        ctx.strokeRect(0,0,w,h);
        
        var nx = snakeArray[0].x;
        var ny = snakeArray[0].y;
        
        if(d == "right") nx++;
        else if (d == "left") nx--;
        else if (d == "up") ny--;
        else if (d == "down") ny++;
        
        //Collide code
        if (nx == -1 || nx == w/cw || ny == -1 || ny == h/cw || checkCollision(nx, ny, snakeArray)){
            //init();
            $("#finalScore").html(score);
            //Show Overlay
            $('#overlay').fadeIn();
            
            return;
        }
        
        if(nx == food.x && ny == food.y){
            var tail = {x: nx, y: ny};
            score++;
            //Create Food
            createFood();
        } else {
            // Migrate the head to the tail
            var tail = snakeArray.pop();
            tail.x = nx;
            tail.y = ny;
        }
        
        snakeArray.unshift(tail);
        
        for (var i = 0; i < snakeArray.length; i++){
            var c = snakeArray[i];
            paintCell(c.x, c.y);
        }
        
        paintCell(food.x, food.y);
        
        // Check Score
        checkScore(score);
    
        // Display current score
        $('#score').html("Your Score: "+score);    
    }
    
    function checkCollision(x, y, array){
        for (var i = 0; i < array.length; i++){
            if (array[i].x == x && array[i].y == y)
                return true;
        }
        return false;
    }
    
    function checkScore(score){
        if (localStorage.getItem("highscore") === null){
            // If there is no high score
            localStorage.setItem("highscore", score);
        } else {
            // If there is a high score
            if (score > localStorage.getItem("highscore")){
                localStorage.setItem("highscore", score);
            }
        }
        $('#highScore').html("High Score: "+localStorage.highscore);
    }
    
    function paintCell(x, y){
        ctx.fillStyle = color;
        ctx.fillRect(x*cw,y*cw,cw,cw);
        ctx.strokeStyle = "white";
        ctx.strokeRect(x*cw,y*cw,cw,cw);
    }
    
    //Keyboard Controller
    $(document).keydown(function(e){
        var key = e.which;
        if(key == "37" && d != "right")
            d = "left";
        else if (key == "39" && d !="left")
            d = "right";
        else if (key == "38" && d != "down")
            d = "up";
        else if (key == "40" && d != "up")
            d = "down";
    });
});

function resetScore(){
    localStorage.highscore = 0;
    // Display high score
    highscorediv = document.getElementById("highScore");
    highscorediv.innerHTML = "High Score: 0";
}