var c = document.getElementById("myCanvas");
var ctx = c.getContext("2d");

function drawLine() {
    ctx.moveTo(0, 0);
    ctx.lineTo(500, 100);
    ctx.stroke();
}
drawLine();